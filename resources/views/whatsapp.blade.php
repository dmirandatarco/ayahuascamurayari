
<div class="container-whatsapp">
	<input type="checkbox" id="btn-whatsapp">
	<div class="user-whatsapp">
		<div class="header-whatsapp">
			<div class="row">
				<div class="col-md-2">
					<i class="fab fa-whatsapp fa-3x"></i>
				</div>
				<div class="col-md-9 header-titulo ">
					<span class="titulo-whatsapp">Chatea con Nosotros</span>
					<span class="parrafo-whatsapp">Hola! Elige a uno de nuestros
						agentes de viaje para chatear vía Whatsapp	</span>
				</div>	
			</div>
		</div>
		<div class="body-whatsapp">
			<span class="text-nuestroequipo" >Nuestro equipo responderá inmediatamente!</span>
			<a href="https://wa.me/51{{$whatsapp->numero}}?text=*Hola*" target="_blank">
			<div class="enlace-whatsapp">
				<div class="row">
					<div class="col-md-2">
						<i class="fab fa-whatsapp fa-3x" ></i>
					</div>
					<div class="col-md-9 header-titulo ">
						<span class="titulo-enlace">{{$whatsapp->nombre}}</span>
						<span class="parrafo-enlace">{{$whatsapp->cargo}}</span>
					</div>	
				</div>
			</div>
			</a>
			
		</div>
		
	</div>
	<div class="btn-whatsapp">
		<label for="btn-whatsapp" class="icon-whatsapp"><i class="fab fa-whatsapp " ></i></label>
	</div>
</div>
