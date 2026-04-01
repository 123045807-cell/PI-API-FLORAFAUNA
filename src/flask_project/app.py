from flask import Flask, render_template, session, redirect, url_for, request, flash
from config import Config
import api_client as api

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

IMAGENES_ZONAS = {
    1: "jalpan.jpg",
    2: "landa.jpg",
    3: None,
    4: "pinal.jpg",
    5: "sanjoaquin.jpg",
    6: "penamiller.jpg",
    7: "cadereyta.png",
    8: None,
    9: None,
    10: None,
    11: None,
    12: None,
    13: None,
    14: None,
    15: None,
    16: None,
    17: None,
    18: "amealco.jpg",
}


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
    usuario = session.get("usuario", {})
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
    consejos = api.get_consejos()
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
    imagen_zona = IMAGENES_ZONAS.get(id_zona)
    especies    = api.get_especies_por_zona(id_zona)
    consejos    = api.get_consejos_por_zona(id_zona)

    return render_template(
        "zona.html",
        id_zona=id_zona,
        nombre_zona=nombre_zona,
        imagen_zona=imagen_zona,
        especies=especies,
        consejos=consejos,
        
    )


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)