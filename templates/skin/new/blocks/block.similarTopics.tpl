{if $aSimilarTopics}
    <section class="block block-type-stream">
        <header class="block-header">
            <h3>{$aLang.plugin.similar.block_similar_articles_title}</h3>
        </header>
        <div class="block-content">
            <div class="block-content">
                <ul class="latest-list">
                    {foreach from=$aSimilarTopics item=oTopic name="cmt"}
                        {assign var="oBlog" value=$oTopic->getBlog()}
                        {assign var="oUser" value=$oTopic->getUser()}

                        <li {if $smarty.foreach.cmt.iteration % 2 == 1}class="even"{/if}>
                            <a href="{$oUser->getUserWebPath()}" class="user">{$oUser->getLogin()}</a>&nbsp;&#8594;
                            <a href="{$oTopic->getUrl()}" class="topic-title">{$oTopic->getTitle()|escape:'html'}</a>
                            <span> {$oTopic->getCountComment()}</span> &RightArrow; <a href="{$oBlog->getUrlFull()}" class="blog-title">{$oBlog->getTitle()|escape:'html'}</a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </section>
{/if}