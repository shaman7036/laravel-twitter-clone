<?php
    if(!isset($tag)) $tag = '';
?>
<div class='search'>
    <input class='form-control' onkeydown='onSearch(event)' value={{$tag}}>
    <i class='fa fa-search'></i>
</div>

<style>
.search {
    position: relative;
}
.search > input {
    position: relative;
    top: 7.5px;
    width: 200px;
    height: 30px;
    border-radius: 30px;
    padding-top: 5px;
    box-shadow: 0px 0px 0px rgba(0,0,0,.075);
}
.search > i {
    position: absolute;
    right: 10px;
    top: 15px;
    color: #888;
}
@media screen and (max-width: 1000px) {
    .search {
        display: none;
    }
}
</style>
<script>
function onSearch(e) {
    console.log('on_search() e.keyCode='+e.keyCode+' e.target.value='+e.target.value);
    if(e.keyCode === 13) {
        window.location.href = '/hashtag/'+e.target.value;
    }
}
</script>
