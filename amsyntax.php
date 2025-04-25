<?php
/*
amsyntax es una clase que ayuda a crear un bloque de codigo formateando el texto y agregando
resaltado de sintaxis de manera automatica en una pagina web.

Modo de uso:
-------------------------------------------------
<?php
require_once 'amsyntax.php';

// Instanciar la clase
$highlighter = new NGS();

// Codigo rust
$codigoRust = <<<'RUST'
fn main() {
    let nombre = "Mundo";
    println!("¡Hola, {}!", nombre);

    // Este es un comentario bien perron
    for i in 0..5 {
        println!("Número: {}", i);
    }

    // Llamada a una funcion
    let resultado = suma(5, 10);
    println!("Resultado: {}", resultado);
}

// Funcion de muestra
fn suma(a: i32, b: i32) -> i32 {
    a + b
}
RUST;

// Activar la sintaxis en el codigo
echo $highlighter->syntax_on($codigoRust);
?>

Creado por anonimichi 30/03/2025
*/
class amsyntax {
	// Por ahora solo he implementado el resaltado de sintaxis para RUST porque es el que estoy
	// necesitando para crear mi blog... per facilmente puede adaptarse a otros lenguajes usando
	// los diferentes arreglos que siguen aqui abajo.
		
	// Colores para sintaxis de Rust
	private $styles = [
		'keywords' => 'color: #ff79c6; font-weight: bold;', 	// Palabras clave
		'types' => 'color: #8be9fd;', 												// Tipos
		'functions' => 'color: #50fa7b;', 										// Funciones
		'macros' => 'color: #5afad2; font-weight: bold;', 		// Macros
		'strings' => 'color: #f1fa8c;', 											// Cadenas
		'comments' => 'color: #6272a4; font-style: italic;', 	// Comentarios
		'numbers' => 'color: #ffb86c;', 											// Numeros
	];

	// Palabras clave de Rust
	private $keywords = [
		'fn', 'let', 'mut', 'if', 'else', 'match', 'loop', 'while', 'for', 'in', 'break', 'continue',
		'return', 'impl', 'trait', 'struct', 'enum', 'mod', 'pub', 'use', 'crate', 'super', 'self',
		'const', 'static', 'async', 'await', 'move', 'unsafe', 'dyn', 'type', 'where', 'as', 'ref',
		'box', 'extern', 'true', 'false', 'Some', 'None', 'Ok', 'Err',
	];

	// Tipos comunes en Rust
	private $types = [
		'i32', 'i64', 'u32', 'u64', 'f32', 'f64', 'usize', 'isize', 'bool', 'char', 'str', 'String', 'Vec', 'Option', 'Result',
	];

	// Resalta el código Rust
	public function syntax_on($code) {
		// $code = htmlspecialchars($code);

		// Resaltar cadenas (entre comillas dobles o simples)
		$code = preg_replace('/(".*?")/', '<span style="' . $this->styles['strings'] . '">$1</span>', $code);
		$code = preg_replace("/('.*?')/", '<span style="' . $this->styles['strings'] . '">$1</span>', $code);

		// Resaltar comentarios (lineas que comienzan con // o bloques /* */)
		$code = preg_replace('/(\/\/.*?$)/m', '<span style="' . $this->styles['comments'] . '">$1</span>', $code);
		$code = preg_replace('/(\/\*[\s\S]*?\*\/)/', '<span style="' . $this->styles['comments'] . '">$1</span>', $code);
		// Resaltar numeros
		$code = preg_replace('/\b(\d+)\b/', '<span style="' . $this->styles['numbers'] . '">$1</span>', $code);

		// Resaltar macros 
		$code = preg_replace('/\b(\w+)!\(/', '<span style="' . $this->styles['macros'] . '">$1</span>!(', $code);

		// Resaltar palabras clave
		foreach ($this->keywords as $keyword) {
			$code = preg_replace('/\b(' . preg_quote($keyword) . ')\b/', '<span style="' . $this->styles['keywords'] . '">$1</span>', $code);
		}

		// Resaltar tipos
		foreach ($this->types as $type) {
			$code = preg_replace('/\b(' . preg_quote($type) . ')\b/', '<span style="' . $this->styles['types'] . '">$1</span>', $code);
		}

		// Resaltar nombres de funciones (seguido de parentesis)
		$code = preg_replace('/\b(\w+)\s*(?=\()/m', '<span style="' . $this->styles['functions'] . '">$1</span>', $code);

		// Envolver el codigo en un bloque preformateado
		return '<pre style="background: #282a36; color: #f8f8f2; padding: 1rem; border-radius: 8px; font-family: monospace; overflow-x: auto;"><code>' . $code . '</code></pre>';
	}
}
