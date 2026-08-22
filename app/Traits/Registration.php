<?php

namespace Asylum\Theme\Traits;

trait Registration
{
    /**
     * Find reg marks and make them superscript
     *
     * @param string $content
     * @return string
     */
    protected function superscriptRegMark(?string $content = null): string
    {
        if (!$content) {
            return '';
        }

        return preg_replace('/(?<=[a-z0-9])(?:®|&reg;|&#0*174;?|&#x0*ae;?)/i', '<sup>&reg;</sup>', $content);
    }
}
