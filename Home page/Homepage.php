<!DOCTYPE html>
<html lang="en">
<!--divinectorweb.com-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosedale Residence Website</title>
    <!-- All CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-icon/font/bootstrap-icons.css">
   
   <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
-->
<style>
 /*@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap');*/
 @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
* {
	font-family: 'Poppins', sans-serif;
}
body {
	background: #FFECD6;
}
.section-padding {
	padding: 100px 0;
}
.carousel-item {
	height: 100vh;
	min-height: 300px;
}
.carousel-caption {
	bottom: 220px;
	z-index: 2;
}
.carousel-caption h5 {
	font-size: 45px;
	text-transform: uppercase;
	letter-spacing: 2px;
	margin-top: 25px;
}
.carousel-caption p {
	width: 60%;
	margin: auto;
	font-size: 18px;
	line-height: 1.9;
}
.carousel-inner:before {
	content: '';
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background: rgba(0, 0, 0, 0.7);
	z-index: 1;
}
.navbar .getstarted {
	background: #106eea;
	margin-left: 30px;
	border-radius: 4px;
	font-weight: 400;
	color: #fff;
	text-decoration: none;
	padding: .5rem 1rem;
	line-height: 2.3;
}
.navbar-nav a {
	font-size: 13px;
	text-transform: uppercase;
	font-weight: 500;
}
.navbar-light .navbar-brand {
	color: #000;
	font-size: 20px;
	text-transform: uppercase;
	font-weight: bold;
	letter-spacing: 2px;
}
.navbar{
	background-color: #FFECD6;
}
.navbar-light .navbar-brand:focus, .navbar-light .navbar-brand:hover {
	color: #000;
}
.navbar-light .navbar-nav .nav-link {
	color: #000;
}
.navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
	color: #000;
}
.w-100 {
	height: 100vh;
}
.navbar-toggler {
	padding: 1px 5px;
	font-size: 18px;
	line-height: 0.3;
	background: #fff;
}
.portfolio .card {
	box-shadow: 15px 15px 40px rgba(0, 0, 0, 0.15);
}
.team .card {
	box-shadow: 15px 15px 40px rgba(0, 0, 0, 0.15);
}
.services .card-body i {
	font-size: 50px;
}
.team .card-body i {
	font-size: 20px;
}
@media only screen and (min-width: 768px) and (max-width: 991px) {
	.carousel-caption {
		bottom: 370px;
	}
	.carousel-caption p {
		width: 100%;
	}
	.card {
		margin-bottom: 30px;
	}
	.img-area img {
		width: 100%;
	}
}
@media only screen and (max-width: 767px) {
	.navbar-nav {
		text-align: center;
	}
	.carousel-caption {
		bottom: 125px;
	}
	.carousel-caption h5 {
		font-size: 17px;
	}
	.carousel-caption a {
		padding: 10px 15px;
		font-size: 15px;
	}
	.carousel-caption p {
		width: 100%;
		line-height: 1.6;
		font-size: 12px;
	}
	.about-text {
		padding-top: 50px;
	}
	.card {
		margin-bottom: 30px;
	}
}
</style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#"><span style="color: #3559E0;">Rosedale</span> Residence</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
              </li> 
              <li class="nav-item">
                <a class="nav-link" href="#services">Services</a>
              </li> 
              <!--<li class="nav-item">
                <a class="nav-link" href="#portfolio">Portfolio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#team">Team</a>
              </li>--> 
              <li class="nav-item">
                <a class="nav-link" href="#contact">Contact</a>
              </li>        
              <li class="nav-item">
                <a class="nav-link" href="User/index.php" style="color: #3559E0; font-weight: bold;">Login</a>
              </li>        
              <li class="nav-item">
                <a class="nav-link" href="User/register.php" style="font-weight: bold;">Sign Up</a>
              </li>        

            </ul>
          </div>
        </div>
      </nav>
         
         
         
         <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="img/1.png" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h5 style="font-weight: bold; font-size: 2.8rem; color: ">Welcome</h5>
                              <p style="font-size: 1.5rem; font-weight: bold;">ROSEDALE RESIDENCES WEBSITE</p>
                              <span>"Smart Billing, Steamless Living: Elevate Your Subdivision Experience"</span>
                              <p><a href="#" class="btn btn-warning mt-3">Explore</a></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h5 style="font-weight: bold; font-size: 2.8rem; color: ">About us</h5>
                              <p style="font-size: 1rem;"> Experience the convenience of automated billing processes and comprehensive financial insights with our billing management system, providing you with the tools to optimize revenue management and ensure efficient financial control.</p>
                              <p><a href="" class="btn btn-warning mt-3">Learn More</a></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/3.png" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h5 style="font-weight: bold; font-size: 2.8rem; color: ">Service</h5>
                              <p>It is very important for the customer to pay attention to the adipiscing process. Most of all, there is no time.
                                 They leave it to be accepted, which it is true.</p>
                              <p><a href="#" class="btn btn-warning mt-3">Learn More</a></p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <!-- about section starts -->
      <section id="about" class="about section-padding">
          <div class="container">
              <div class="row">
                  <div class="col-lg-4 col-md-12 col-12">
                      <div class="about-img">
                          <img src="img/about1.png" alt="" class="img-fluid">
                      </div>
                  </div>
                  <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                      <div class="about-text">
                            <h2>About<br/></h2>
                            <p style="text-align: justify;"> 
                            Rosedale Residence is implementing a billing management system on our subdivision website to simplify the process 
                            of handling various payments and enhance the overall experience for residents. We aim to automate the billing process, 
                            ensuring that bills for services such as maintenance fees and utilities are easily generated and promptly delivered to residents.
                            </p>
                        </div>
                  </div>
              </div>
          </div>
      </section>
      <!-- about section Ends -->
      <!-- services section Starts -->
      <section class="services section-padding" id="services">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <div class="section-header text-center pb-5">
                          <h2>Our Services</h2>
                          <p>How this portal works?<br></p>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-browser-chrome"></i>
                            <h3 class="card-title">1 - Login</h3>
                            <p class="lead" style="font-size: 1rem; text-align: center;">&nbsp;&nbsp;Experience swift and secure access to your account with our streamlined login process. 
                            Enjoy a seamless and private user experience, putting you in control account to acessible billing system.</p>
                            </div>
                    </div>
                </div>
                  <div class="col-12 col-md-12 col-lg-4">
                      <div class="card text-white text-center bg-dark pb-2">
                          <div class="card-body">
                            <i class="bi bi bi-envelope-at-fill"></i>
                              <h3 class="card-title">2 - Peruse Bills</h3>
                              <p class="lead" style="font-size: 1rem;">Navigate through proposed legislation with ease, utilizing our intuitive interface to peruse bills, 
                                view comprehensive summaries, and stay informed about the latest legislative developments.</p>
                            </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-4">
                      <div class="card text-white text-center bg-dark pb-2">
                          <div class="card-body">
                            <i class="bi bi-newspaper"></i>
                              <h3 class="card-title">3 - Transaction</h3>
                              <p class="lead" style="font-size: 1rem;">Simplify financial transactions with our user-friendly billing system, enabling swift and secure 
                                payments, tracking transaction history, and ensuring a hassle-free experience for all your billing needs.</p>
                            </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      <!-- services section Ends -->

      <!-- portfolio strats -->
      <!--<section id="portfolio" class="portfolio section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Our Projects</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur <br>adipisicing elit. Non, quo.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                          <div class="img-area mb-4">
                              <img src="img/project-1.jpg" class="img-fluid" alt="">
                          </div>
                            <h3 class="card-title">Building Make</h3>
                            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci eligendi modi temporibus alias iste. Accusantium?</p>
                            <button class="btn bg-warning text-dark">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                          <div class="img-area mb-4">
                              <img src="img/project-2.jpg" class="img-fluid" alt="">
                          </div>
                            <h3 class="card-title">Building Make</h3>
                            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci eligendi modi temporibus alias iste. Accusantium?</p>
                            <button class="btn bg-warning text-dark">learn More</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                          <div class="img-area mb-4">
                              <img src="img/project-3.jpg" class="img-fluid" alt="">
                          </div>
                            <h3 class="card-title">Building Make</h3>
                            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci eligendi modi temporibus alias iste. Accusantium?</p>
                            <button class="btn bg-warning text-dark">Learn More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section>-->
      <!-- portfolio ends -->
      <!-- team starts -->
      <section class="team section-padding" id="team">
          <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Our Team</h2>
                        <p>It is very important for the <br>customer to pay attention to the adipiscing process. No, where</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="img/jade.png" alt="" class="img-fluid rounded-circle">
                        <h3 class="card-title py-2">Jade Ryan L. Blancaflor</h3>
                        <p class="card-text">
                        As a seasoned full-stack web developer, I blend creativity with technical expertise to craft dynamic and responsive websites.
                         From front-end design finesse to back-end functionality, I deliver comprehensive solutions that bring digital visions to life.  
                      </p>
                        

                        <p class="socials">
                        <a href="https://www.twitter.com/"><i class="bi bi-twitter text-dark mx-1"></i></a>
                        <a href="https://www.facebook.com/"><i class="bi bi-facebook text-dark mx-1"></i></a>
                        <a href="https://www.linkedin.com/"><i class="bi bi-linkedin text-dark mx-1"></i></a>
                        <a href="https://www.instagram.com/"><i class="bi bi-instagram text-dark mx-1"></i></a>
                        </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="img/128x128.png" alt="" class="img-fluid rounded-circle">
                        <h3 class="card-title py-2">Ma. Angelica M. Rubrico</h3>
                        <p class="card-text">
                        As a dedicated Quality Assurance professional, I ensure excellence through meticulous testing and process evaluation, guaranteeing the highest standards of product and service quality. 
                        My commitment to continuous improvement defines my role in maintaining superior quality standards.
                        </p>
                        <p class="socials">
                            <i class="bi bi-twitter text-dark mx-1"></i>
                        <i class="bi bi-facebook text-dark mx-1"></i>
                        <i class="bi bi-linkedin text-dark mx-1"></i>
                        <i class="bi bi-instagram text-dark mx-1"></i>
                        </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="img/mona1.png" alt="" class="img-fluid rounded-circle">
                        <h3 class="card-title py-2">Mona Lyn C. Bularon</h3>
                        <p class="card-text">
                        As a dedicated documentation specialist, I meticulously organize and present information, ensuring clarity and accessibility. 
                        Streamlining my work empowers seamless understanding, making information readily available for all. 
                      </p>
                        <p class="socials">
                            <i class="bi bi-twitter text-dark mx-1"></i>
                        <i class="bi bi-facebook text-dark mx-1"></i>
                        <i class="bi bi-linkedin text-dark mx-1"></i>
                        <i class="bi bi-instagram text-dark mx-1"></i>
                        </p>
                        </div>
                    </div>
                </div>
               
            </div>
          </div>
      </section>
      <!-- team ends -->
      <!-- Contact starts -->
      <section id="contact" class="contact section-padding">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Contact Us</h2>
                        <p>It is very important for the <br>customer to pay attention to the adipiscing process. No, where</p>
                    </div>
                </div>
            </div>
			<div class="row m-0">
				<div class="col-md-12 p-0 pt-4 pb-4">
					<form action="#" class="bg-light p-4 m-auto">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<input class="form-control" placeholder="Full Name" required="" type="text">
								</div>
							</div>
							<div class="col-md-12">
								<div class="mb-3">
									<input class="form-control" placeholder="Email" required="" type="email">
								</div>
							</div>
							<div class="col-md-12">
								<div class="mb-3">
									<textarea class="form-control" placeholder="Message" required="" rows="3"></textarea>
								</div>
							</div><button class="btn btn-danger btn-lg btn-block mt-3" type="button">
                Send Now&nbsp<i class="bi bi-send-check"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
      </section>
      <!-- contact ends -->
      <!-- footer starts -->
<footer class="bg-dark p-2 text-center">
    <div class="container">
        <p class="text-white" id="copyright"></p>
    </div>

    <script>
        document.getElementById('copyright').innerHTML = 'All Right Reserved By Rosedale Residence &copy; ' + new Date().getFullYear();
    </script>
</footer>
      <!-- footer ends -->








    
    
    <!-- All Js -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>




<!--for getting the form download the code from download button-->