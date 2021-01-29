<?php

require_once __DIR__ . '/../Template.php';

it('translates correct foreach syntax for indexed arrays', function () {
    $t = new TrunkTemplates\Template();
    $template = '{* :foreach(cases as case) *}{* case *},{* :endforeach *}';
    $data = ['cases' => ['case1', 'case2', 'case3']];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('case1,case2,case3,');
});

it('translates correct foreach syntax for associative arrays', function () {
    $t = new TrunkTemplates\Template();
    $template = '{* :foreach(cases as case => desc) *}{* case *} = {* desc *},{* :endforeach *}';
    $data = ['cases' => ['case1' => 'Case 1 desc', 'case2' => 'Case 2 desc', 'case3' => 'Case 3 desc']];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('case1 = Case 1 desc,case2 = Case 2 desc,case3 = Case 3 desc');
});
