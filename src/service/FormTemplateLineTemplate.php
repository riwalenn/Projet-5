<?php

class FormTemplateLineTemplate implements LineTemplate
{

    public function getTemplateLineString(): string
    {
        $html = "<label for='<?= \$label ?>'><?= \$value ?></label>";
        $html .= "<input name='synthese[value][]' id='<?= \$label ?>' data-name='value' value='<?= \$value; ?>' class='required' type='number'>";
        $html = "<label for='<?= \$label ?>_percent'>En % du budget</label>";
        $html .= "<input name='synthese[value_percent][]' id='<?= \$label ?>' data-name='value_percent' value='' class='required' type='number'>";
        return $html;
    }
}