<script type="text/javascript">
function quickSick () {
    var dealField = new Array('sickDate','sortType');
    var waitHrefTemp = new Array();
    for(var i=0;i<dealField.length;i++){
        var itemValue = document.getElementById(dealField[i]).value.trim();
        if(itemValue=='') continue;
        var temp = dealField[i]+'='+itemValue;
        waitHrefTemp.push(temp);
    }
    waitHref = waitHrefTemp.join('&');
    document.location.href='index.php?r=back/admin/adminDeal&dType=memberLog&userAccount=<?php echo $userName; ?>&'+waitHref;
}
</script>
<div id="mainTB">
    <div class="pageTitle">管理日志</div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTable">
    <tr>
        <td colspan="4" style="padding-left:5px;border-right:none;height:30px">
            <span>请选择记录周期：</span>
            <span>
                <select id="sickDate" name="sickDate" onchange="quickSick()">
                    <option value="0">请选择</option>
                    <?php foreach ($logDateBox as $key => $box): ?>
                        <option value="<?php echo $box['date']; ?>" <?php echo $box['tag']; ?>><?php echo $box['date']; ?></option>
                    <?php endforeach ?>
                </select>
            </span>
            <span style="margin-left:20px">当前帐号：<?php echo $userName; ?></span>
        </td>
        <td style="padding-right:5px;border-right:none;height:30px;text-align:right">
            <span>请选择查看方式：</span>
            <span>
                <select id="sortType" name="sortType" onchange="quickSick()">
                    <option value="0">快速查看</option>
                    <?php foreach ($sortSelect as $key => $sort): ?>
                        <option value="<?php echo $sort['value']; ?>" <?php echo $sort['tag']; ?>><?php echo $sort['title']; ?></option>
                    <?php endforeach ?>
                </select>
            </span>
        </td>
    </tr>
    <tr>
        <th><span class="tableHeadTitle">操作人</span></th>
        <th><span class="tableHeadTitle">登录IP</span></th>
        <th><span class="tableHeadTitle">地理位置</span></th>
        <th><span class="tableHeadTitle">操作时间</span></th>
        <th><span class="tableHeadTitle">操作内容</span></th>
    </tr>
    <?php foreach ($sickLog as $key => $log): ?>
    <tr>
        <td class="firstRow" style="text-align:center"><?php echo $log['action_name']; ?></td>
        <td class="firstRow" style="text-align:center"><?php echo $log['action_ip']; ?></td>
        <td class="firstRow" style="text-align:center"><?php echo $log['action_area']; ?></td>
        <td class="firstRow" style="text-align:center"><?php echo $log['action_time']; ?></td>
        <td class="firstRow" style="text-align:left;padding-left:10px;padding-right:10px;line-height:22px;width:520px"><?php echo $log['action_detail']; ?></td>
    </tr>
    <?php endforeach ?>
    </table>
    <?php echo $page; ?>
</div>