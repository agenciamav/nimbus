<!DOCTYPE html>
<?php include('inc/controle-configuracao.php'); ?>
<html lang="pt">
<?php include('inc/head.php'); ?>
<body>

	<!-- Header -->
	<section id="header">		
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">

				<!-- logo-->
				<div class="navbar-header">             
					<a class="navbar-brand logo" href="#header">
						<img src="img/logo.jpg" alt="Logo" class="img-responsive">
					</a>
				</div>
				<!-- fim logo-->

				<!-- menu -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">                    
						<li>
							<a href="#conheca">CONHEÇA A </br>CONSTRUTORA</a>
						</li>
						<li>
							<a href="#emandamento">EMPREENDIMENTOS</br>EM ANDAMENTO</a>
						</li>
						<li>
							<a href="#obrasconcluidas">OBRAS </br>CONCLUÍDAS</a>
						</li>
						<li>
							<a href="#contato">FALE </br>CONOSCO</a>
						</li>
						<li class="separator">
							<a>|</a>
						</li>
						<li>
							<a href="#">
								<img src="img/facebook.png" alt="facebook" class="img-responsive">
							</a>
						</li>		
					</ul>
				</div>
				<!-- fim menu-->
			</div>
			<!-- /.container-->
		</nav>	
	</section>
	<!-- /Header -->


	<!-- slide-->
	<div id="header_slider" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#header_slider" data-slide-to="0" class=""></li>
			<li data-target="#header_slider" data-slide-to="1" class=""></li>
			<li data-target="#header_slider" data-slide-to="2" class="active"></li>
		</ol>
		<div class="carousel-inner">
			<div class="item">
				<img src="img/slides/1.png" class="img-responsive">
				<div class="container">
					<div class="carousel-caption">
						<h1>PORTO</br>MAIORI</br><hr></br></h1>
						<p>Sofisticação e</br>conforto para</br>uma vida TOP.</p>
					</div>
				</div>
			</div>
			<div class="item">
				<img src="img/slides/1.png" class="img-responsive">
				<div class="container">
					<div class="carousel-caption">
						<h1>TORRES</br>SEVILHA</br><hr></br></h1>
						<p>monumental e</br>impressionante pela</br>infraestrutura e</br>valorização do viver</br>com satisfação.</p>
						
					</div>
				</div>
			</div>
			<div class="item active">
				<img src="img/slides/1.png" class="img-responsive">
				<div class="container">
					<div class="carousel-caption">
						<h1>ALTA</br>CITTÁ</br><hr></br></h1>
						<p>alto padrão e</br>conforto para</br>seu dia a dia.</p>
					</div>
				</div>
			</div>
		</div>
		<a class="left carousel-control" href="#header_slider" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#header_slider" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>

	<!-- Conheça a contrutora -->
	<section id="conheca">
		<div class="container">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<h2>NOSSA <br>HISTÓRIA<br><hr></h2>

			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<h3>Uma empresa </br>dedicada à conquista </br>de seus clientes!</h3>
				<p>Sempre respeitando padrões de alta qualidade e com projetos diferenciados, a Nimbus se destaca no mercado Imobiliário fazendo de seus trabalhos uma sequencia de sucessos..
				</p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<p>A boa localização, com fácil acesso, a estrutura completa de apoio, vista privilegiada e a preocupação com cada detalhe são fatores presentes em todas as obras.
				</p>
				<p>É com tradição e experiência que seguimos nossa trajetória buscando a melhoria continua dos processos construtivos, superando as expectativas e conquistando o reconhecimento dos clientes.”</p>
			</div>
		</div>
	</section>
	<!-- /Conheça a contrutora -->


	<!-- Empreendimentos em andamento -->
	<section id="emandamento">
		<div id="slider_emandamento" class="carousel slide" data-ride="carousel">
			  <!--  <ol class="carousel-indicators">
			        <li data-target="#slider_emandamento" data-slide-to="0" class=""></li>
			        <li data-target="#slider_emandamento" data-slide-to="1" class=""></li>
			        <li data-target="#slider_emandamento" data-slide-to="2" class="active"></li>
			    </ol>-->
			    <a class="left carousel-control" href="#slider_emandamento" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			    <a class="right carousel-control" href="#slider_emandamento" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			    <div class="carousel-inner">


			    	<div class="item active">

			    		<img src="img/em-andamento/fundo-emandamento.jpg" >


			    		<div class="col-md-5">
			    			<div class="carousel-caption">
			    				<h1>EMPREENDIMENTOS</br>EM ANDAMENTO</br><hr></br>
			    					<a class="navbar-brand logo" href="#header">
			    						<img src="img/logo.jpg" alt="Logo" class="img-responsive">
			    					</a>
			    				</h1></br>
			    				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at maximus mi, quis blandit arcu. Curabitur est lacus, aliquet non lobortis ut, </p>
			    			</div>
			    		</div>



			    		<div class="col-md-5">

			    			<div class="mansory">    
			    				<div class="col-md-6">
			    					<img src="img\em-andamento\1.jpg" />
			    				</div>

			    				<div class="col-md-6">
			    					<img src="img\em-andamento\3.jpg" />
			    					<img src="img\em-andamento\4.jpg" />
			    				</div>

			    				<div class="col-md-12">
			    					<img src="img\em-andamento\2.jpg" />
			    				</div>
			    			</div>



			    		</div>

			    	</div>

			    </div>
			</section>
			<!-- /Empreendimentos em andamento -->

			<!-- Obras concluídas -->
			<section id="obrasconcluidas">
				<div class="container">

					<div class="col-md-3">
						<h2>Obras concluídas</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus ut tenetur ullam! Iusto deleniti doloremque voluptates id, repudiandae cupiditate placeat doloribus neque natus odit minus laborum, earum ad harum maxime.</p>
					</div>


					<!-- carousel -->
					<div class="col-md-9">



						<div class="your-class">
							<div>your content</div>
							<div>your content</div>
							<div>your content</div>
						</div>


<!--<div class="carousel-reviews broun-block">
    
            <div id="carousel-reviews" class="carousel slide" data-ride="carousel">
            
                <div class="carousel-inner">
                    <div class="item active">
                	    <div class="col-md-4 col-sm-6">
        				    <div class="block-text rel zmin">
						        <a title="" href="#">Hercules</a>
							    <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
						        <p>Never before has there been a good film portrayal of ancient Greece's favourite myth. So why would Hollywood start now? This latest attempt at bringing the son of Zeus to the big screen is brought to us by X-Men: The last Stand director Brett Ratner. If the name of the director wasn't enough to dissuade ...</p>
							    <ins class="ab zmin sprite sprite-i-triangle block"></ins>
					        </div>
							<div class="person-text rel">
				                
								<a title="" href="#">Anna</a>
								<i>from Glasgow, Scotland</i>
							</div>
						</div>
            			<div class="col-md-4 col-sm-6 hidden-xs">
						    <div class="block-text rel zmin">
						        <a title="" href="#">The Purge: Anarchy</a>
							    <div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star-empty"></span><span data-value="3" class="glyphicon glyphicon-star-empty"></span><span data-value="4" class="glyphicon glyphicon-star-empty"></span><span data-value="5" class="glyphicon glyphicon-star-empty"></span>  </span></div>
        						<p>The 2013 movie "The Purge" left a bad taste in all of our mouths as nothing more than a pseudo-slasher with a hamfisted plot, poor pacing, and a desperate attempt at "horror." Upon seeing the first trailer for "The Purge: Anarchy," my first and most immediate thought was "we really don't need another one of these."  </p>
					            <ins class="ab zmin sprite sprite-i-triangle block"></ins>
				            </div>
							<div class="person-text rel">
				                
						        <a title="" href="#">Ella Mentree</a>
								<i>United States</i>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 hidden-sm hidden-xs">
							<div class="block-text rel zmin">
								<a title="" href="#">Planes: Fire & Rescue</a>
								<div class="mark">My rating: <span class="rating-input"><span data-value="0" class="glyphicon glyphicon-star"></span><span data-value="1" class="glyphicon glyphicon-star"></span><span data-value="2" class="glyphicon glyphicon-star"></span><span data-value="3" class="glyphicon glyphicon-star"></span><span data-value="4" class="glyphicon glyphicon-star"></span><span data-value="5" class="glyphicon glyphicon-star"></span>  </span></div>
    							<p>What a funny and entertaining film! I did not know what to expect, this is the fourth film in this vehicle's universe with the two Cars movies and then the first Planes movie. I was wondering if maybe Disney pushed it a little bit. However, Planes: Fire and Rescue is an entertaining film that is a fantastic sequel in this magical franchise. </p>
								<ins class="ab zmin sprite sprite-i-triangle block"></ins>
							</div>
							<div class="person-text rel">
								
								<a title="" href="#">Rannynm</a>
								<i>Indonesia</i>
							</div>
						</div>
                                       
                </div>
                <a class="left carousel-control" href="#carousel-reviews" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-reviews" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>
</div>-->


</div>

</div>
</section>
<!-- /Obras concluídas -->

<!-- Contato -->
<section id="contato" style="background-color: #566981;">
	<div class="container">

		<div class="col-md-3">
			<h2>FALE</br>CONOSCO</br><hr></br></h2>
			<strong>Fale</strong>
			<p>(54) 3452.6909</p>

			<strong>Envie</strong>
			<p>contato@nimbus.com.br</p>

			<strong>Visite</strong>
			<p>Rua Barão do Rio Branco, 71<br>
				Centro . Bento Gonçalves . RS</p>
			</div>

			<!-- form -->
			
			<div class="col-md-9">
				<div class="form-area">  
					<form role="form">
						<br style="clear:both">

						<div class="form-group">
							<input type="text" class="form-control" id="name" name="NOME" placeholder="NOME" required>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="email" name="EMAIL" placeholder="EMAIL" required>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="mobile" name="FONE" placeholder="TELEFONE" required>
						</div>

						<div class="form-group">
							<textarea class="form-control" type="textarea" id="message" placeholder="MENSAGEM" maxlength="140" rows="7"></textarea>

						</div>

						<button type="button" id="submit" name="submit" class="btn btn-primary pull-right">ENVIAR</button>
					</form>
				</div>
			</div>

		</div>
	</section>
	<!-- /Contato -->

	<!-- Mapa -->
	<section id="mapa">
		<div class="container-fluid">
			<div class="row-fluid">

				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1741.9398720634933!2d-51.51747478014824!3d-29.16821578629946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1434740879047" width="100%" height="400" frameborder="0" style="border:0"></iframe>


			</div>
		</div>
	</section>
	<!-- /Mapa -->


	<!-- rodapé -->
	<footer>
		<div class="col-md-10">
			<p>Nimbus Empreendimentos Imobiliários  .  ©2015  .  Todos os Direitos Reservados     </p>
		</div>

		<div class="col-md-2">
			<p><a href="http://www.s72.com.br" target="_blank">S72</a></p>
		</div>

	</footer>
	<!-- /rodapé -->

	<?php include('inc/footer.php'); ?>		
</body>
</html>