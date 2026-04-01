from flask import Flask, render_template, session, redirect, url_for, request, flash
from config import Config
import api_client as api
import unicodedata

app = Flask(__name__)
app.config.from_object(Config)

ZONAS = {
    1: "Jalpan de Serra",
    2: "Landa de Matamoros",
    3: "Arroyo Seco",
    4: "Pinal de Amoles",
    5: "San Joaquín",
    6: "Peñamiller",
    7: "Cadereyta de Montes",
    8: "Tolimán",
    9: "Colón",
    10: "Ezequiel Montes",
    11: "Tequisquiapan",
    12: "San Juan del Rio",
    13: "Pedro Escobedo",
    14: "El Marqués",
    15: "Querétaro",
    16: "Corregidora",
    17: "Huimilpan",
    18: "Amealco de Bonfil",
}


def normalize_text(text):
    if not text:
        return ""
    normalized = unicodedata.normalize("NFKD", text)
    normalized = "".join(ch for ch in normalized if not unicodedata.combining(ch))
    return normalized.lower().strip()

CONSEJO_IMAGENES = {
    normalize_text("Protección del Mirlo café"): "mirlo.jpg",
    normalize_text("Cuidado del Chamal"): "chamal.jpg",
    normalize_text("Control de residuos"): "residuos.jpg",
    normalize_text("Senderos responsables"): "senderos.jpg",
    normalize_text("Respeto a la fauna"): "fauna.jpg",
    normalize_text("Protección de la Tangara Azulgrís"): "tangara.jpg",
    normalize_text("Cuidado del Mirto coral"): "mirto.jpg",
    normalize_text("Arañas benéficas"): "arana.jpg",
    normalize_text("Reforestación responsable"): "reforestacion.jpg",
    normalize_text("Guacamayas verdes"): "guacamaya.jpg",
    normalize_text("Hormigas chicatanas"): "hormiga.jpg",
    normalize_text("Alacrancillo medicinal"): "alacrancillo.jpg",
    normalize_text("Control de incendios"): "incendios.jpg",
    normalize_text("Protección de ranas"): "rana.jpg",
    normalize_text("Mariposas en peligro"): "mariposa.jpg",
    normalize_text("Álamos blancos"): "alamo.jpg",
    normalize_text("Turismo responsable"): "turismo.jpg",
    normalize_text("Chara pecho gris"): "chara.jpg",
    normalize_text("Carpinteros belloteros"): "carpintero.jpg",
    normalize_text("Mirto chico"): "mirtochico.jpg",
    normalize_text("Senderismo responsable"): "senderismo.jpg",
    normalize_text("Peyote protegido"): "peyote.jpg",
    normalize_text("Aves insectívoras"): "aves.jpg",
    normalize_text("Zopilotes benéficos"): "zopilote.jpg",
    normalize_text("Conservación de suelos"): "suelos.jpg",
    normalize_text("Garambullo comestible"): "garambullo.jpg",
    normalize_text("Colibríes en peligro"): "colibri.jpg",
    normalize_text("Carpinteros cheje"): "cheje.jpg",
    normalize_text("Cactáceas nativas"): "cactaceas.jpg",
    normalize_text("Biznagas endémicas"): "biznagas.jpg",
    normalize_text("Reptiles protegidos"): "reptiles.jpg",
    normalize_text("Turismo ecológico"): "ecoturismo.jpg",
    normalize_text("Manzanilla de llano"): "manzanilla.jpg",
    normalize_text("Gallito de monte"): "gallito.jpg",
    normalize_text("Control de especies invasoras"): "invasoras.jpg",
    normalize_text("Consumo responsable"): "consumo.jpg",
    normalize_text("Kalanchoe ornamental"): "kalanchoe.jpg",
    normalize_text("Biznaga de acitrón"): "acitron.jpeg",
    normalize_text("Chapulín arcoíris"): "chapulin.jpg",
    normalize_text("Mariposa Monarca"): "monarca.jpg",
    normalize_text("Biznaga ganchuda"): "ganchuda.jpg",
    normalize_text("Centzontle norteño"): "centzontle.jpg",
    normalize_text("Conservación de humedales"): "humedales.jpg",
    normalize_text("Agricultura sostenible"): "agricultura.jpg",
    normalize_text("Jardines polinizadores"): "polinizadores.jpg",
    normalize_text("Árboles nativos"): "arboles.jpg",
    normalize_text("Control de plagas natural"): "plagas.jpg",
    normalize_text("Setos vivos"): "setos.jpg",
    normalize_text("Agua de lluvia"): "lluvia.png",
    normalize_text("Biodiversidad agrícola"): "biodiversidad.jpg",
    normalize_text("Corredores biológicos"): "corredores.jpeg",
    normalize_text("Techos verdes"): "techos.jpg",
    normalize_text("Humedales artificiales"): "humedales_artificiales.jpg",
    normalize_text("Control biológico"): "biologico.jpg",
    normalize_text("Educación ambiental"): "educacion.jpg",
    normalize_text("Jardines urbanos"): "jardines.jpg",
    normalize_text("Aves urbanas"): "avesurbanas.jpg",
    normalize_text("Movilidad sostenible"): "movilidad.jpeg",
    normalize_text("Árboles urbanos"): "arbolesurbanos.jpg",
    normalize_text("Reciclaje comunitario"): "reciclaje.jpg",
    normalize_text("Corredores verdes"): "corredoresverdes.jpg",
    normalize_text("Reforestación urbana"): "reforestacionurbana.jpeg",
    normalize_text("Conservación de cerros"): "cerros.jpeg",
    normalize_text("Agricultura periurbana"): "periurbana.jpg",
    normalize_text("Flor de gallito"): "florgallito.jpg",
    normalize_text("Zafiro orejas blancas"): "zafiro.jpg",
    normalize_text("Capulinero gris"): "capulinero.jpg",
    normalize_text("Ranita de cañón"): "ranita.jpg",
    normalize_text("Carpintero bellotero"): "carpintero.jpg",
    normalize_text("Camaleón de montaña"): "camaleon.jpg",
    normalize_text("Junco ojos de lumbre"): "junco.jpg",
    normalize_text("Pingüica"): "pinguica.jpg",
}


def obtener_imagen_consejo(titulo):
    clave = normalize_text(titulo)
    if clave in CONSEJO_IMAGENES:
        return f"imgconsejos/{CONSEJO_IMAGENES[clave]}"
    for texto, nombre_archivo in CONSEJO_IMAGENES.items():
        if texto in clave:
            return f"imgconsejos/{nombre_archivo}"
    return "imgconsejos/educacion.jpg"


def get_field(data, keys, default=""):
    for key in keys:
        if key in data and data[key] not in (None, ""):
            return data[key]
    return default


def normalizar_consejo(consejo):
    if not isinstance(consejo, dict):
        return consejo

    titulo = get_field(consejo, ["titulo", "Titulo", "Titulo_consejo", "titulo_consejo"])
    if titulo:
        consejo["titulo"] = titulo

    consejo["imagen"] = obtener_imagen_consejo(titulo)

    zona_valor = get_field(consejo, ["zona", "Zona", "ID_zona", "id_zona"])
    if isinstance(zona_valor, int):
        consejo["zona"] = ZONAS.get(zona_valor, zona_valor)
    else:
        try:
            zona_int = int(zona_valor)
            consejo["zona"] = ZONAS.get(zona_int, zona_valor)
        except Exception:
            consejo["zona"] = zona_valor

    texto = get_field(consejo, ["consejo", "Consejo", "contenido", "Contenido", "texto", "Texto"])
    if texto:
        consejo["consejo"] = texto

    fecha = get_field(consejo, ["fecha", "Fecha", "Fecha_publicacion", "fecha_publicacion"])
    if fecha:
        consejo["fecha"] = fecha

    hora = get_field(consejo, ["hora", "Hora", "Hora_publicacion", "hora_publicacion"])
    if hora:
        consejo["hora"] = hora

    return consejo


# ── Páginas generales ─────────────────────────────────────────

@app.route("/")
def inicio():
    return render_template("inicio.html")


@app.route("/inicio_usuario")
def inicio_usuario():
    especies = api.get_especies()
    flora       = sum(1 for e in especies if e.get("tipo") == 1)
    fauna       = sum(1 for e in especies if e.get("tipo") == 2)
    vulnerables = sum(1 for e in especies if e.get("id_estado_conservacion") in (3, 4, 5))

    stats = {"flora": flora, "fauna": fauna, "zonas": len(ZONAS), "vulnerables": vulnerables}

    todas_las_fotos = [e for e in especies if e.get("url_imagen")]
    fotos = {"fotografiadas": len(todas_las_fotos), "pendientes": len(especies) - len(todas_las_fotos)}

    zonas_carrusel = [
        {"nombre": "Jalpan de Serra",     "ruta": "imagenes_zonas/jalpan.jpg"},
        {"nombre": "Peñamiller",          "ruta": "imagenes_zonas/penamiller.jpg"},
        {"nombre": "Pinal de Amoles",     "ruta": "imagenes_zonas/pinal.jpg"},
        {"nombre": "Cadereyta de Montes", "ruta": "imagenes_zonas/cadereyta.png"},
        {"nombre": "Landa de Matamoros",  "ruta": "imagenes_zonas/landa.jpg"},
        {"nombre": "San Joaquín",         "ruta": "imagenes_zonas/sanjoaquin.jpg"},
        {"nombre": "Amealco de Bonfil",   "ruta": "imagenes_zonas/amealco.jpg"},
    ]

    return render_template("inicio_usuario.html", stats=stats, fotos=fotos, zonas=zonas_carrusel)


# ── Auth ──────────────────────────────────────────────────────

@app.route("/login", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        correo    = request.form.get("correo")
        contrasena = request.form.get("contraseña")
        resultado = api.login_usuario(correo, contrasena)
        if resultado:
            session["usuario"] = resultado
            session["rol"]     = resultado.get("rol")
            flash("Inicio de sesión exitoso.", "success")
            return redirect(url_for("inicio_usuario"))
        else:
            flash("Correo o contraseña incorrectos.", "error")
            return redirect(url_for("login"))
    return render_template("login.html")


@app.route("/registro", methods=["GET", "POST"])
def registro():
    if request.method == "POST":
        datos = {
            "nombre":          request.form.get("nombre"),
            "apellidoPaterno": request.form.get("ap_paterno"),
            "apellidoMaterno": request.form.get("ap_materno"),
            "correo":          request.form.get("correo"),
            "contrasena":      request.form.get("contraseña"),
        }
        resultado = api.crear_usuario(datos)
        if resultado:
            flash("Cuenta creada exitosamente. Inicia sesión.", "success")
            return redirect(url_for("login"))
        else:
            flash("Error al crear la cuenta. El correo puede estar en uso.", "error")
            return redirect(url_for("registro"))
    return render_template("registro.html")


@app.route("/logout")
def logout():
    session.clear()
    return redirect(url_for("login"))


# ── Perfil ────────────────────────────────────────────────────

@app.route("/perfil")
def perfil():
    usuario = session.get("usuario")
    if not usuario:
        return redirect(url_for("login"))

    if isinstance(usuario, dict):
        usuario_id = get_field(usuario, ["id", "ID", "ID_usuario", "id_usuario"])
        if usuario_id:
            try:
                usuario_id = int(usuario_id)
                usuario_api = api.get_usuario(usuario_id)
                if isinstance(usuario_api, dict):
                    usuario.update(usuario_api)
                    session["usuario"] = usuario
            except Exception:
                pass

        nombre = get_field(usuario, ["nombre", "Nombre", "first_name", "firstName"])
        apellido_paterno = get_field(usuario, ["apellidoPaterno", "apellido_paterno", "ApellidoPaterno"])
        apellido_materno = get_field(usuario, ["apellidoMaterno", "apellido_materno", "ApellidoMaterno"])
        correo = get_field(usuario, ["correo", "Correo", "email", "Email"])
        rol = get_field(usuario, ["rol", "Rol", "role", "Role"], "Usuario Registrado")

        nombre_completo = " ".join([p for p in [nombre, apellido_paterno, apellido_materno] if p]).strip()
        usuario["full_name"] = nombre_completo or correo or "Usuario"
        usuario["email"] = correo or usuario.get("email", "")
        usuario["rol_text"] = rol
        usuario["profile_image"] = usuario.get("profile_image") or usuario.get("imagen") or "default.png"
    else:
        usuario = {
            "full_name": "Usuario",
            "email": "",
            "rol_text": "Usuario Registrado",
            "profile_image": "default.png",
        }

    return render_template("perfil.html", usuario=usuario)


# ── Contenido ─────────────────────────────────────────────────

@app.route("/mapa")
def mapa():
    return render_template("mapa.html")


@app.route("/mapa2")
def mapa2():
    return render_template("mapa2.html")


@app.route("/consejos")
def consejos():
    consejos = api.get_consejos() or []
    for consejo in consejos:
        normalizar_consejo(consejo)
    return render_template("consejos.html", consejos=consejos)


@app.route("/comentarios", methods=["GET", "POST"])
def comentarios():
    if request.method == "POST":
        from datetime import date
        datos = {
            "Contenido":         request.form.get("contenido"),
            "Fecha_publicacion": str(date.today()),
            "ID_usuario":        session.get("usuario", {}).get("id"),
            "ID_zona":           int(request.form.get("id_zona")),
            "ID_estatus":        1
        }
        api.crear_comentario(datos)
        flash("Comentario publicado.", "success")
        return redirect(url_for("comentarios"))

    comentarios = api.get_comentarios()
    zonas = [{"ID": k, "nombre_region": v} for k, v in ZONAS.items()]
    id_usuario = session.get("usuario", {}).get("id")
    return render_template("comentarios.html", comentarios=comentarios, zonas=zonas, id_usuario=id_usuario)


@app.route("/comentario/like/<int:id>", methods=["POST"])
def like_comentario(id):
    resultado = api.like_comentario(id)
    if resultado:
        return {"success": True}
    return {"success": False}, 400


@app.route("/comentario/eliminar/<int:id>", methods=["POST"])
def eliminar_comentario(id):
    api.eliminar_comentario(id)
    flash("Comentario eliminado.", "success")
    return redirect(url_for("comentarios"))


@app.route("/comentario/editar/<int:id>", methods=["POST"])
def editar_comentario(id):
    contenido = request.form.get("contenido")
    api.editar_comentario(id, contenido)
    flash("Comentario actualizado.", "success")
    return redirect(url_for("comentarios"))
@app.route("/donaciones")
def donaciones():
    return render_template("donaciones.html")


@app.route("/donaciones2")
def donaciones2():
    return render_template("donaciones2.html")


@app.route("/membresias")
def membresias():
    return render_template("membresias.html")


# ── Zonas ─────────────────────────────────────────────────────

@app.route("/zona/<int:id_zona>")
def zona(id_zona):
    if id_zona not in ZONAS:
        return redirect(url_for("inicio"))

    nombre_zona = ZONAS[id_zona]
    especies    = api.get_especies_por_zona(id_zona)
    consejos    = api.get_consejos_por_zona(id_zona) or []
    for consejo in consejos:
        normalizar_consejo(consejo)

    return render_template(
        "zona.html",
        id_zona=id_zona,
        nombre_zona=nombre_zona,
        especies=especies,
        consejos=consejos,
    )


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)