{assign var="results" value=$results|default:false}
{extends file="page.tpl"}

{block name="header"}{/block}

{block name="content"}

        <div class="container readable-width">

            <div class="page-header">
                <h1>{$title}</h1>
            </div>

            {include file="search.tpl"}

        </div>


        {if $results !== false}
            {include file="results.tpl"}
        {/if}
    </div>

{/block}

{block name="footer"}

    <div class="container readable-width">
        <div class="alert alert-warning" role="alert">
            This is a project very, very much <a class="alert-link" href="https://github.com/smtech/stmarks-search/issues">under development</a> at the moment. Please <a class="alert-link" href="mailto:sethbattis@stmarksschool.org?subject=St.+Mark%92s+Search">share feedback with Seth</a>!
        </div>
    </div>

{/block}
