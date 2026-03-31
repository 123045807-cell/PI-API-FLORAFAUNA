from flask import Flask, render_template, session, redirect, url_for
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


# ── Páginas generales ─────────────────────────────────────────

@app.route("/")
def inicio():
    return render_template("inicio.html")


@app.route("/inicio_usuario")
def inicio_usuario():
    especies = api.get_especies()
    flora      = sum(1 for e in especies if e.get("tipo") == 1)
    fauna      = sum(1 for e in especies if e.get("tipo") == 2)
    vulnerables = sum(1 for e in especies if e.get("id_estado_conservacion") in (3, 4, 5))
    zonas      = len(ZONAS)

    stats = {"flora": flora, "fauna": fauna, "zonas": zonas, "vulnerables": vulnerables}

    todas_las_fotos = [e for e in especies if e.get("url_imagen")]
    fotografiadas   = len(todas_las_fotos)
    pendientes      = len(especies) - fotografiadas
    fotos = {"fotografiadas": fotografiadas, "pendientes": pendientes}

    return render_template("inicio_usuario.html", stats=stats, fotos=fotos)


@app.route("/login")
def login():
    return render_template("login.html")


@app.route("/registro")
def registro():
    return render_template("registro.html")


@app.route("/perfil")
def perfil():
    usuario = {
        "username": "Isabel",
        "profile_image": "isabel.png"
    }
    return render_template("perfil.html", usuario=usuario)


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


@app.route("/comentarios")
def comentarios():
    comentarios = api.get_comentarios()
    return render_template("comentarios.html", comentarios=comentarios)


@app.route("/donaciones")
def donaciones():
    return render_template("donaciones.html")


@app.route("/donaciones2")
def donaciones2():
    return render_template("donaciones2.html")


@app.route("/membresias")
def membresias():
    return render_template("membresias.html")


# ── Zonas (una sola ruta dinámica) ────────────────────────────

@app.route("/zona/<int:id_zona>")
def zona(id_zona):
    if id_zona not in ZONAS:
        return redirect(url_for("inicio"))

    nombre_zona = ZONAS[id_zona]
    especies    = api.get_especies_por_zona(id_zona)
    consejos    = api.get_consejos_por_zona(id_zona)

    return render_template(
        "zona.html",
        id_zona=id_zona,
        nombre_zona=nombre_zona,
        especies=especies,
        consejos=consejos,
    )


# ── Auth ──────────────────────────────────────────────────────

@app.route("/logout")
def logout():
    session.clear()
    return redirect(url_for("login"))


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
