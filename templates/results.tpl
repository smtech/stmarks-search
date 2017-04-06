<div class="container readable-width">
{if count($results)>0}
    <table class="table table-striped">
    {foreach $results as $result}
        <tr><td>
            <p>
                <a href="{$result->getUrl()}">{$result->getTitle()}</a>
                <span class="label label-default rationale" data-toggle="tooltip" data-placement="bottom" title="{$result->getRelevance()->getRationale(PHP_EOL)}">
                    {$result->getRelevance()->getScore()}
                </span>
                <span class="pull-right">
                    <small>from <a href="{$result->getSource()->getUrl()}">{$result->getSource()->getName()}</a></small>
                </span>
            </p>
            <p>{$result->getDescription()}</p>
        </td></tr>
    {/foreach}
    </table>
{else}
    <p>No results.</p>
{/if}
</div>
