##To call this --> Rscript --vanilla params.R '../rmd.Rmd' 'pdf_document' '../archivo.pdf' 1 123
##To call this --> Rscript --vanilla params.R '../rmd.Rmd' 'html_document' '..pagina.html' ejemplo 123
args <- commandArgs(trailingOnly = TRUE)
Sys.setenv(HOME = "/home/rodrigomassiolo")
rmarkdown::render(
                  args[1],#path archivo Rmd a procesar
                  args[2],#pdf_document o html_document
                  params = list ( data=args,
                                  pacienteEjercicio=args[4],
                                  energy=args[5],
                                  eGemaps=args[6],
                                  chroma=args[7],
                                  audspec=args[8],
                                  prosody=args[9]
                   ),
                  #params = list (
                  #               ejercicio = args[4],
                  #               user = args[5]
                  #              ),
                  output_file = args[3],#path archivo salida
                  encoding="UTF-8"
                )