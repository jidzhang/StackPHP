<?php
/**
 * Created by PhpStorm.
 * User: zhangjidong
 * Date: 2018/2/11
 * Time: 16:44
 */

require_once "src/api.php";
$q = $_GET['q'];

if (isset($q)) {
    $sort = $_GET['sort'];
    $tag  = $_GET['tag'];
    $site = API::Site("stackoverflow");
    if (!isset($sort))
        $sort = 'relevance';
    try {
        $response = $site->Questions()->Search($q)->Tagged($tag)->SortBy($sort)->Exec();
        $response = $response->Pagesize(6)->Page(1);
    } catch (APIException $e) {
        echo $e->Details();
    }

    $q_list = [];
    while ($item = $response->Fetch(false)) {
        $q_list[] = $item;
    }

    echo  '<ul>';
    foreach ($q_list as $item) {
        echo "<li><a href={$item['link']}>[" . $item['score']. ']'.$item['title'] .'</a></li>';
    }
    echo '</ul>';

    if ($response->Fetch(true)) {
        echo '<a>more...</a>';
    }

} else {

    ?>

    <form method="get">

        <label for="search_text">搜索关键字: </label> <input id="search_text" name="q" type="text"><br>
        <label for="sort">排序: </label>
        <select name="sort">
            <option value="relevance">相关度</option>
            <option value="votes">投票</option>
            <option value="creation">创建时间</option>
            <option value="activity">活跃度</option>
        </select><br>
        <label for="tag">标签</label><input id="tag" name="tag" type="text">

        <input type="submit" value="提交">
    </form>

    <?php
}

?>