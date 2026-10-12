# Tema de WordPress · Totech

Tema a medida con el mismo diseño de la web estática: inicio animado, servicios, método, diferenciadores, público, valores y formulario de contacto.

## Instalación

1. Descarga `totech.zip` (está en esta misma carpeta).
2. En WordPress entra a **Apariencia → Temas → Añadir nuevo → Subir tema**.
3. Selecciona `totech.zip`, pulsa **Instalar ahora** y después **Activar**.

La portada del sitio muestra la landing completa automáticamente, sin configurar nada más.

## Qué se puede editar sin tocar código

**Apariencia → Personalizar → Totech**

- **Inicio:** etiqueta superior, título principal, texto de apoyo, texto del botón y descripción para buscadores. Para resaltar una palabra en lima dentro del título, escríbela así: `<span class="hl">palabra</span>`.
- **Contacto y formulario:** sitio web, correo y teléfono visibles, razón social del pie de página y **el correo que recibe las solicitudes del formulario**. Si ese campo se deja vacío, las solicitudes llegan al correo de administración de WordPress.

**Apariencia → Personalizar → Identidad del sitio**

- **Logo:** si subes uno, reemplaza al logotipo blanco del tema en la navegación y el pie. Conviene usar una versión clara, porque ambos fondos son oscuros.
- **Ícono del sitio:** el favicon. Si no subes uno, se usa el símbolo de Totech.

**Apariencia → Menús**

- Hay dos ubicaciones: **Menú principal** y **Menú del pie de página**. Si no asignas ninguno, se muestran los enlaces a las secciones de la portada.
- Para enlazar una sección de la portada, usa un *enlace personalizado* con la URL del sitio seguida del ancla, por ejemplo `https://totech.com.mx/#servicios`. Las anclas disponibles son `#nosotros`, `#servicios`, `#metodo`, `#diferenciadores`, `#clientes`, `#valores` y `#contacto`.

## Formulario de contacto

El formulario envía un correo con los datos de la solicitud. Usa la función de correo de WordPress, así que:

- Se recomienda instalar un plugin SMTP (por ejemplo **WP Mail SMTP**) para que los correos no lleguen a spam.
- Incluye protección contra envíos automáticos (nonce y campo trampa) y valida los campos en el navegador y en el servidor.
- Al responder el correo recibido, la respuesta va directo a quien llenó el formulario.

## Contenido de las secciones

Los textos de servicios, método, diferenciadores, público y valores están en `template-parts/section-*.php`, uno por sección. Se pueden editar desde **Apariencia → Editor de archivos del tema** o por FTP.

## Páginas internas

Las páginas (por ejemplo, un aviso de privacidad), las entradas del blog y la página 404 usan el mismo estilo de la marca, con encabezado oscuro y navegación fija.
