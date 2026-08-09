<?php

namespace Asylum\Theme\Block\Widget;

use Asylum\Block\WidgetBlockController;

use StoutLogic\AcfBuilder\FieldsBuilder;

class JumpLinks extends WidgetBlockController
{
    protected ?string $name = 'jump-links';

    /**
     * Allowed post types
     *
     * @var array
     */
    protected array $postTypes = [];

    /**
     * Block category
     *
     * @var string
     */
    protected string $category = 'asylum-widgets';

    protected array $headers = [];

    protected ?string $content = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('title');
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        if (is_admin()) {
            return;
        }

        if (!$this->headers) {
            $this->addJumpLinks(apply_filters('the_content', get_the_content()));
            add_filter('the_content', [$this, 'addJumpLinks']);
        }

        $data['links'] = $this->headers;
    }

    public function addJumpLinks(string $content): string
    {

        if ($this->content) {
            return $this->content;
        }
        preg_match_all('/<h2(?:.*)>(.*)<\/h2>/', $content, $matches);

        foreach ($matches[0] as $key => $h2) {
            $title = $title = trim(strtolower(preg_replace('#\W+#', '-', $matches[1][$key])));
            $id = sprintf('link-%s', $title);

            $inserted = str_replace('<h2', sprintf('<h2 id="%s"', $id), $h2);

            if (!in_array(['id' => $id, 'title' => $matches[1][$key]], $this->headers)) {
                array_push($this->headers, ['id' => $id, 'title' => $matches[1][$key]]);
            }

            $content = str_replace($h2, $inserted, $content);
        }

        $this->content = $content;

        return $content;
    }
}
