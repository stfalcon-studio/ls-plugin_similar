{if $aSimilarTopics}
    <section class="block block-type-stream">
        <header class="block-header">
            <h3>{$aLang.plugin.similar.block_similar_articles_title}</h3>
        </header>
        <div class="block-content">
            <ul class="latest-list">
                {foreach from=$aSimilarTopics item=oTopic name="cmt"}
                    {assign var="oBlog" value=$oTopic->getBlog()}
                    {assign var="oUser" value=$oTopic->getUser()}

                    <li title="{$oTopic->getText()|strip_tags|trim|truncate:150:'...'|escape:'html'}">
                        <p>
                            <a href="{$oUser->getUserWebPath()}" class="author">{$oUser->getLogin()}</a>
                            <time datetime="{date_format date=$oTopic->getDateAdd() format='c'}" title="{date_format date=$oTopic->getDateAdd() format="j F Y, H:i"}">
                                {date_format date=$oTopic->getDateAdd() hours_back="12" minutes_back="60" now="60" day="day H:i" format="j F Y, H:i"}
                            </time>
                        </p>
                        <a href="{$oBlog->getUrlFull()}" class="stream-blog">{$oBlog->getTitle()|escape:'html'}</a> &rarr;
                        <a href="{$oTopic->getUrl()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>
                        <span class="block-item-comments"><i class="icon-synio-comments-small"></i>{$oTopic->getCountComment()}</span>
                    </li>
                {/foreach}
            </ul>
        </div>
    </section>
{/if}