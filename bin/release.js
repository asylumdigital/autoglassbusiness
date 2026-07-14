// // const versionBump = require('npm-version-bump');
const semver = require('semver');
const path = require('path');
const replace = require("replace");
const util = require('node:util');
const { readFile } = require('fs/promises')
const exec = util.promisify(require('node:child_process').exec);


const release = async () => {

    await exec('git checkout main && git pull && composer up');

    const pkg = require('../package.json');

    const changelog = await readFile('./changelog.md', 'utf8');

    const update = changelog.match(/## \[Unreleased\] - yyyy-mm-dd\n+?###\s/);

    const updateText = !update ? `\r\n\r\n### Updated\r\n\r\n- Composer dependencies` : '';


    const versionStr = process.argv.pop();

    const date = new Date();
    const dateFormat = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, "0")}-${date.getDate().toString().padStart(2, "0")}`;


    let version = semver.valid(versionStr);
    if (!version) version = semver.inc(pkg.version, versionStr)


    const name = path.basename(path.resolve(__dirname, '..'));

    replace(
        {
            regex: /Version:\s*(.*)/,
            replacement: `Version: ${version}`,
            paths: [`./style.css`],
            recursive: true,
            silent: true,
        },
    );

    replace(
        {
            regex: /"version": "(.*)"/,
            replacement: `"version": "${version}"`,
            paths: [`./package.json`],
            recursive: true,
            silent: true,
        },
    );

    replace(
        {
            regex: /## \[Unreleased\] - yyyy-mm-dd/,
            replacement: `## [Unreleased] - yyyy-mm-dd\r\n\r\n## [${version}] - ${dateFormat}${updateText}`,
            paths: [`./changelog.md`],
            recursive: true,
            silent: true,
        },
    );

    await exec(`git add . && git commit -m "Release ${version}" && git push && git tag ${version} && git push --tags`);
    console.log(`Released v${version}`);


    console.log('Merging back to develop');

    await exec(`git checkout develop && git merge -X theirs main`);

    const devVersion = semver.inc(version, 'patch');

    replace(
        {
            regex: /Version:\s*(.*)/,
            replacement: `Version: ${devVersion}`,
            paths: [`./style.css`],
            recursive: true,
            silent: true,
        },
    );

    await exec(`git add . && git commit -m "Dev bump ${devVersion}" && git push`);
}

release();
