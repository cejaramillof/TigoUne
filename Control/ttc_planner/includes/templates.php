<script type="text/html" id="tmpl-edit-event">
    <div class="plnr-event-edit">
        <h2>Registro de actividad</h2>
        <form id="plnr-event-form">
            <input type="hidden" id="plnr-event-edit-date" name="date" value="<%= date %>">
            <div class="form-item">
                <fieldset id="plnr-event-edit-activity">
                    <legend>Actividad a realizar</legend>
                    <label><input name="activity[]" type="checkbox" value="Acompañamiento"> Acompañamiento</label>
                    <label><input name="activity[]" type="checkbox" value="Entrenamiento"> Entrenamiento</label>
                    <label><input name="activity[]" type="checkbox" value="Inducción"> Inducción</label>
                    <label><input name="activity[]" type="checkbox" value="Reunión"> Reunión</label>
                    <label><input name="activity[]" type="checkbox" value="Train the Trainers"> Train the Trainers</label>
                    <label><input name="activity[]" type="checkbox" value="Otro"> Otro</label>
                </fieldset>
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-notes">Observaciones</label>
                <textarea id="plnr-event-edit-notes" name="observaciones" rows="5"></textarea>
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-poscode">Código POS/Circuito/ID</label>
                <input type="text" id="plnr-event-edit-poscode" name="poscode" value="">
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-poscode_name">Nombre del punto</label>
                <input type="text" id="plnr-event-edit-poscode_name" name="poscode_name" value="">
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-channel">Canal</label>
                <select id="plnr-event-edit-channel" name="channel">
                    <option value="" selected disabled>Selecciona un canal</option>
                    <option value="TIENDAS_PROPIAS">CDE (movil)</option>
                    <option value="FUERZA_VD">FVD (movil)</option>
                    <option value="RETAIL">RETAIL (movil)</option>
                    <option value="DEALERS">DEALER (movil)</option>
                    <option value="GESTORES">GESTORES (movil)</option>
                    <option value="CVDS">CDVS (hogares)</option>
                    <option value="GESTORES">CONTACT CENTER (hogares)</option>
                    <option value="GESTORES">PAP (hogares)</option>
                    <option value="GESTORES">PUNTOS FIJOS (hogares)</option>
                    <option value="OTRO">AUR Y CONSTRUCTORES (hogares)</option>
                    <option value="NA">No aplica</option>
                </select>
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-regional">Regional</label>
                <select id="plnr-event-edit-regional" name="regional">
                    <option value="" selected disabled>Selecciona una regional</option>
                    <option value="CENTRO">Centro</option>
                    <option value="COSTA">Costa</option>
                    <option value="EJE_CAFETERO">Eje Cafetero</option>
                    <option value="NOROCCIDENTE">Noroccidente</option>
                    <option value="ORIENTE">Oriente</option>
                    <option value="SUROCCIDENTE">Suroccidente</option>
                    <option value="NA">No aplica</option>
                </select>
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-department">Departamento</label>
                <select id="plnr-event-edit-department" name="department">
                    <option value="" selected disabled>Selecciona un departamento</option>
                    <option value="AMAZONAS">Amazonas</option>
                    <option value="ANTIOQUIA">Antioquia</option>
                    <option value="ARAUCA">Arauca</option>
                    <option value="ATLANTICO">Atlántico</option>
                    <option value="BOLIVAR">Bolívar</option>
                    <option value="BOYACA">Boyacá</option>
                    <option value="CALDAS">Caldas</option>
                    <option value="CAQUETA">Caquetá</option>
                    <option value="CASANARE">Casanare</option>
                    <option value="CAUCA">Cauca</option>
                    <option value="CESAR">Cesar</option>
                    <option value="CHOCO">Chocó</option>
                    <option value="CORDOBA">Córdoba</option>
                    <option value="CUNDINAMARCA">Cundinamarca</option>
                    <option value="GUAINIA">Guainía</option>
                    <option value="GUAVIARE">Guaviare</option>
                    <option value="HUILA">Huila</option>
                    <option value="GUAJIRA">La Guajira</option>
                    <option value="MAGDALENA">Magdalena</option>
                    <option value="META">Meta</option>
                    <option value="NARINO">Nariño</option>
                    <option value="NORTE_SANTANDER">Norte de Santander</option>
                    <option value="PUTUMAYO">Putumayo</option>
                    <option value="QUINDIO">Quindío</option>
                    <option value="RISARALDA">Risaralda</option>
                    <option value="SAN_ANDRES_PROVIDENCIA">San Andrés y Providencia</option>
                    <option value="SANTANDER">Santander</option>
                    <option value="SUCRE">Sucre</option>
                    <option value="TOLIMA">Tolima</option>
                    <option value="VALLE_DEL_CAUCA">Valle del Cauca</option>
                    <option value="VAUPES">Vaupés</option>
                    <option value="VICHADA">Vichada</option>
                    <option value="NA">No aplica</option>
                    <option value="COLOMBIA">Colombia</option>
                </select>
            </div>
            <div class="form-item">
                <label for="plnr-event-edit-city">Ciudad/Población</label>
                <input type="text" id="plnr-event-edit-city" name="city" value="">
            </div>
            <div class="form-item-actions">
                <span class="form-item-action form-submit">Guardar</span><span class="form-item-action form-discard">Descartar</span>
            </div>
        </form>
    </div>
</script>