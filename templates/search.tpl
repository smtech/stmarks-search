{extends file="form.tpl"}

{block name="form-content"}

    <div class="form-group readable-width">
        <div class="input-group">
            <input name="query" value="{$query|default:""}" placeholder="Check request form, phone list, writing comments&hellip;"  type="text" class="form-control"/>
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">Search</button>
            </span>
        </div>
        <p class="help-block">Searching across {$searchDomainCount} sources</p>
    </div>
{/block}

{block name="form-buttons"}{/block}
