{assign var="results" value=$results|default:false}
{extends file="page.tpl"}

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
