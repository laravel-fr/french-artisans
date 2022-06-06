<?php

$creators = yaml_parse_file(__DIR__ . '/../creators.yml');

$content = makeContent($creators);

file_put_contents(__DIR__ . '/../README.md', $content);

function makeContent(array $creators)
{
    $stub = file_get_contents(__DIR__ . '/../stubs/readme.stub');

    foreach ($creators as $category => $creatorsByCategory) {
        if (empty($creatorsByCategory)) {
            $stub = str_replace("{creators.$category}", '*Appel aux créateurs, on vous garde la place au chaud...*', $stub);

            continue;
        }

        $creatorsRow = array_map(function ($creator) {
            return makeCreatorContent($creator);
        }, $creatorsByCategory);

        $stub = str_replace("{creators.$category}", implode("\n", $creatorsRow), $stub);
    }

    return $stub;
}

function makeCreatorContent(array $creator)
{
    $stub = file_get_contents(__DIR__ . '/../stubs/creator.stub');

    foreach (['name', 'url', 'description', 'thumbnail'] as $key) {
        $stub = str_replace("{creator.$key}", $creator[$key], $stub);
    }

    return $stub;
}
