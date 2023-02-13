<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="sectionbody">
    <div class="tablewrap" >
        <?php
        $arr_flds = [
            'listserial' => Label::getLabel('LBL_SRNO'),
            'splatform_identifier' => Label::getLabel('LBL_Title'),
            'splatform_url' => Label::getLabel('LBL_URL'),
            'splatform_active' => Label::getLabel('LBL_Status'),
        ];
        if ($canEdit) {
            $arr_flds['action'] = Label::getLabel('LBL_Action');
        }
        $tbl = new HtmlElement('table', ['width' => '100%', 'class' => 'table table-responsive']);
        $activeLabel = Label::getLabel('LBL_ACTIVE');
        $inactiveLabel = Label::getLabel('LBL_INACTIVE');
        $th = $tbl->appendElement('thead')->appendElement('tr');
        foreach ($arr_flds as $val) {
            $e = $th->appendElement('th', [], $val);
        }
        $sr_no = 0;
        foreach ($records as $sn => $row) {
            $sr_no++;
            $tr = $tbl->appendElement('tr', []);
            foreach ($arr_flds as $key => $val) {
                $td = $tr->appendElement('td');
                switch ($key) {
                    case 'listserial':
                        $td->appendElement('plaintext', [], $sr_no);
                        break;
                    case 'splatform_active':
                        $active = "";
                        $statusAct = 'activeStatus(this)';
                        if ($row['splatform_active'] == AppConstant::ACTIVE) {
                            $active = 'active';
                            $statusAct = 'inactiveStatus(this)';
                        }
                        if ($row['splatform_active'] == AppConstant::INACTIVE) {
                            //$active = 'unchecked';
                            $statusAct = 'activeStatus(this)';
                        }
                        $statusClass = '';
                        if ($canEdit === false) {
                            $statusClass = "disabled";
                            $statusAct = '';
                        }
                        $str = '<label id="' . $row['splatform_id'] . '" class="statustab status_' . $row['splatform_id'] . ' ' . $active . '" onclick="' . $statusAct . '">
                        <span data-off="' . $activeLabel . '" data-on="' . $inactiveLabel . '" class="switch-labels"></span>
                        <span class="switch-handles ' . $statusClass . '"></span>
                    </label>';
                        $td->appendElement('plaintext', [], $str, true);
                        break;
                    case 'action':
                        $ul = $td->appendElement("ul", ["class" => "actions actions--centered"]);
                        if ($canEdit) {
                            $li = $ul->appendElement("li", ['class' => 'droplink']);
                            $li->appendElement('a', ['href' => 'javascript:void(0)', 'class' => 'button small green', 'title' => Label::getLabel('LBL_Edit')], '<i class="ion-android-more-horizontal icon"></i>', true);
                            $innerDiv = $li->appendElement('div', ['class' => 'dropwrap']);
                            $innerUl = $innerDiv->appendElement('ul', ['class' => 'linksvertical']);
                            $innerLiEdit = $innerUl->appendElement('li');
                            $innerLiEdit->appendElement('a', ['href' => 'javascript:void(0)', 'class' => 'button small green', 'title' => Label::getLabel('LBL_Edit'), "onclick" => "addFormNew(" . $row['splatform_id'] . ")"], Label::getLabel('LBL_Edit'), true);
                        }
                        break;
                    default:
                        $td->appendElement('plaintext', [], $row[$key], true);
                        break;
                }
            }
        }
        if (count($records) == 0) {
            $tbl->appendElement('tr')->appendElement('td', ['colspan' => count($arr_flds)], Label::getLabel('LBL_No_Records_Found'));
        }
        echo $tbl->getHtml();
        ?>
    </div> 
</div>	