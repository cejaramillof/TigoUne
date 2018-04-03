<div id="master-container">
	<div id="form-container">
		<div class="container" id="tabs-container">

			<div class="wphone">
				<div class="wphonescreen">
					<div class="left-col" id="form-col">
						<div class="loading">Loading...</div>
					</div>
				</div>
			</div>

			<div class="right-col" id="toolbox-col">

				<ul class="nav-tabs" role="tablist">
					<li class="active toolbox-tab" data-target="#add-field" title="Adicionar elemento"><i class="fa fa-plus-circle" aria-hidden="true"></i> Elemento</li>
					<li class="toolbox-tab" data-target="#field-settings" title="Configurar elemento"><i class="fa fa-cog" aria-hidden="true"></i> Elemento</li>
					<li class="toolbox-tab" data-target="#form-settings" title="Configuración de formulario"><i class="fa fa-wpforms" aria-hidden="true"></i>Configurar formulario</li>
					<li class="toolbox-tab" data-target="#rules">Reglas</li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active" id="add-field">
						<div class="col-sm-12">

							<ul class="witemlist">
								<li class="new-element" data-type="element-titulo"><i class="fa fa-font" aria-hidden="true"></i><span>Título</span></li>
								<li class="new-element" data-type="element-calendario"><i class="fa fa-calendar" aria-hidden="true"></i><span>Fecha</span></li>
								<li class="new-element" data-type="element-email"><i class="fa fa-envelope" aria-hidden="true"></i><span>Email</span></li>
								<li class="new-element" data-type="element-selector"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i><span>Selector</span></li>
								<li class="new-element" data-type="element-radio"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span>Radio</span></li>
								<li class="new-element" data-type="element-multiple-choice"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Checkbox</span></li>
								<li class="new-element" data-type="element-single-line-text"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span>Texto</span></li>
								<li class="new-element" data-type="element-paragraph-text"><i class="fa fa-align-justify" aria-hidden="true"></i><span>Área de texto</span></li>
								<li class="new-element" data-type="falta"><i class="fa fa-user" aria-hidden="true"></i><span>Asesor</span></li>
								<li class="new-element" data-type="falta"><i class="fa fa-users" aria-hidden="true"></i><span>Asesores</span></li>
							</ul>
							<!-- 
							<button class="button new-element" data-type="element-single-line-text" style="width: 100%;">Single Line Text</button>
							<button class="button new-element" data-type="element-paragraph-text" style="width: 100%;">Paragraph Text</button>
							<button class="button new-element" data-type="element-multiple-choice" style="width: 100%;">Multiple Choice</button>
							<button class="button grey new-element" style="width: 100%;">Section Break</button>
							<button class="button new-element" data-type="element-number" style="width: 100%;">Number</button>
							<button class="button new-element" data-type="element-checkboxes" style="width: 100%;">Checkboxes</button>
							<button class="button new-element" data-type="element-dropdown" style="width: 100%;">Dropdown</button>
							<button class="button grey new-element" data-type="element-section-autocomplete" style="width: 100%;">Asesores</button>
							-->
						</div>
					</div>

					<div class="tab-pane" id="field-settings">
						<div class="section">
							<div class="form-group">
								<label>Etiqueta de campo</label>
								<input type="text" class="form-control" id="field-label" />
							</div>
						</div>

						<div class="section" id="field-choices" style="display: none;">
							<div class="form-group"><label>Opciones</label></div>
						</div>

						<div class="section" id="field-options"> 
							<div class="form-group"><label>Opciones de campo</label></div>

							<div class="field-options">
								<div class="checkbox">
									<label><input type="checkbox" id="required">Requerido</label>
								</div>
							</div>
						</div>

						<div class="section" id="field-description"> 
							<div class="form-group"><label>Descripción del campo</label></div>
							<div class="field-description"><textarea class="form-control" id="description"></textarea></div>
						</div>

						<button class="button danger control-remove-field" >Eliminar</button>
						<button class="button" id="control-add-field">Agregar campo</button>
					</div>

					<div class="tab-pane" id="form-settings">
						<div class="section">
							<div class="form-group">
								<label>Título</label>
								<input type="text" class="bind-control form-control" data-bind="#form-title-label" id="form-title" value="" />
							</div>

							<div class="form-group">
								<label>Descripción</label>
								<textarea class="bind-control form-control" data-bind="#form-description-label" id="form-description"></textarea>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="rules">
						<p>Cuando se guardan las reglas, ya no se pueden modificar. Para anular una regla, elimine primero y cree una nueva.</p>
						<div style="margin-bottom: 15px;"><button id="control-add-rule">Agregar regla</button></div>			
						<!-- RULES COME HERE -->	
					</div>

				</div>

				<button id="save" class="wbtnsuccess">Publicar formulario</button>
				
			</div>
		</div> <!-- /container -->

	</div>

</div>