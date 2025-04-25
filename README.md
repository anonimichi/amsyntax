# AMSyntax
Simple clase de php para dar formato a codigo fuente en Rust, lo uso para crear los bloques de codigo de mi blog.

# Modo de uso:
``` php
<?php
require_once 'amsyntax.php';

// Instanciar la clase
$highlighter = new NGS();

// Código Rust de ejemplo
$codigoRust = <<<'RUST'
fn main() {
    let nombre = "Mundo";
    println!("¡Hola, {}!", nombre);

    // Un comentario de prueba con tabulaciones
    for i in 0..5 {
        println!("Número: {}", i);
    }

    // Llamada a una función
    let resultado = suma(5, 10);
    println!("Resultado: {}", resultado);
}

// Funcion para sumar dos numeros
fn suma(a: i32, b: i32) -> i32 {
    a + b
}
RUST;

// Resaltar el codigo
echo $highlighter->syntax_on($codigoRust);
?>
```
# El resultado seria el codigo formateado, con resaltado de sintaxis y encerrado en un bloque oscuro
![preview](https://github.com/user-attachments/assets/ef416348-c92d-4e55-960c-b9bcf407697b)

