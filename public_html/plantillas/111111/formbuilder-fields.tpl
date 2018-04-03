<ul id="form-elements" style="display: none">

	{#form}
		<li class="form-element wtitleform" id="form-settings-element" data-type="form-settings">
			<h2 id="form-title-label">{title}</h2>
			<p id="form-description-label">{description}</p>
		</li>

		<li>
			<ul id="sortable-elements">
				{#fields} {/fields}
			</ul>
		</li>
	{/form}

</ul>