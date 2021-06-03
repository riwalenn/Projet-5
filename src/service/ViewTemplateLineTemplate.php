<?php


class ViewTemplateLineTemplate implements LineTemplate
{

    public function getTemplateLineString(): string
    {
        $html = "<tr><td><?= \$label; ?></td><td><?= \$value[0]; ?></td><td><?= \$value[1]; ?></td></tr>";
        return $html;
    }
}