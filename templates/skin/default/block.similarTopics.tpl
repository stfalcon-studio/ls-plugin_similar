{if $aSimilarTopics|@count}
    <div class="block stream">

        <div class="tl"><div class="tr"></div></div>
        <div class="cl"><div class="cr">
                <h1>{$aLang.block_similar_articles_title}</h1>
                <div class="block-content">
                    <ul class="stream-content">
                        {foreach from=$aSimilarTopics item=oTopic name="cmt"}
                            {assign var="oBlog" value=$oTopic->getBlog()}
                            {assign var="oUser" value=$oTopic->getUser()}

                            <li {if $smarty.foreach.cmt.iteration % 2 == 1}class="even"{/if}>
                                <a href="{$oUser->getUserWebPath()}" class="stream-author">{$oUser->getLogin()}</a>&nbsp;&#8594;
                                <a href="{$oTopic->getUrl()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>
                                <span> {$oTopic->getCountComment()}</span> в <a href="{$oBlog->getUrlFull()}" class="stream-blog">{$oBlog->getTitle()|escape:'html'}</a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div></div>
        <div class="bl"><div class="br"></div></div>
    </div>
{/if}