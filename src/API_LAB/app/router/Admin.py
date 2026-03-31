from fastapi import APIRouter, Depends, HTTPException

from app.database import get_db
from app.api_key import require_admin

from app.model.Usuario import UsuarioAct
from app.model.especies import Especie as EspecieSchema, EspecieActualizar
from app.model.fotografia import Fotografia
from app.api_key import require_admin, require_api_key

router = APIRouter(
    prefix="/admin",
    tags=["Admin"]
)

# =========================
# ADMIN USUARIOS
# =========================

@router.get("/usuarios")
def obtener_usuarios(
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Usuarios")
    usuarios = cursor.fetchall()
    return usuarios


@router.put("/usuarios/{id}")
def actualizar_usuario(
    id: int,
    datos: UsuarioAct,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Usuarios WHERE id_usuario = %s", (id,))
    usuario = cursor.fetchone()

    if not usuario:
        raise HTTPException(404, "Usuario no encontrado")

    if datos.nombre:
        cursor.execute("UPDATE Usuarios SET nombre=%s WHERE id_usuario=%s", (datos.nombre, id))
    if datos.correo:
        cursor.execute("UPDATE Usuarios SET correo=%s WHERE id_usuario=%s", (datos.correo, id))
    if datos.contrasena:
        cursor.execute("UPDATE Usuarios SET contrasena=%s WHERE id_usuario=%s", (datos.contrasena, id))

    return {"mensaje": "Usuario actualizado"}


@router.delete("/usuarios/{id}")
def eliminar_usuario(
    id: int,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Usuarios WHERE id_usuario=%s", (id,))
    usuario = cursor.fetchone()

    if not usuario:
        raise HTTPException(404, "Usuario no encontrado")

    cursor.execute("DELETE FROM Usuarios WHERE id_usuario=%s", (id,))
    return {"mensaje": "Usuario eliminado"}


# =========================
# ADMIN ESPECIES
# =========================

@router.post("/especies")
def crear_especie(
    datos: EspecieSchema,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute(
        """
        INSERT INTO Especies (Nombre_comun, nombre_cientifico, tipo, id_familia, id_zonas, id_estado_conservacion)
        VALUES (%s, %s, %s, %s, %s, %s)
        """,
        (datos.Nombre_comun, datos.nombre_cientifico, datos.tipo,
         datos.id_familia, datos.id_zonas, datos.id_estado_conservacion)
    )
    return {"mensaje": "Especie creada"}


@router.get("/especies")
def obtener_especies(
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Especies")
    return cursor.fetchall()


@router.put("/especies/{id}")
def actualizar_especie(
    id: int,
    datos: EspecieActualizar,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Especies WHERE id_especie=%s", (id,))
    especie = cursor.fetchone()

    if not especie:
        raise HTTPException(404, "Especie no encontrada")

    if datos.Nombre_comun:
        cursor.execute("UPDATE Especies SET Nombre_comun=%s WHERE id_especie=%s", (datos.Nombre_comun, id))
    if datos.nombre_cientifico:
        cursor.execute("UPDATE Especies SET nombre_cientifico=%s WHERE id_especie=%s", (datos.nombre_cientifico, id))
    if datos.tipo:
        cursor.execute("UPDATE Especies SET tipo=%s WHERE id_especie=%s", (datos.tipo, id))
    if datos.id_familia:
        cursor.execute("UPDATE Especies SET id_familia=%s WHERE id_especie=%s", (datos.id_familia, id))
    if datos.id_zonas:
        cursor.execute("UPDATE Especies SET id_zonas=%s WHERE id_especie=%s", (datos.id_zonas, id))
    if datos.id_estado_conservacion:
        cursor.execute("UPDATE Especies SET id_estado_conservacion=%s WHERE id_especie=%s", (datos.id_estado_conservacion, id))

    return {"mensaje": "Especie actualizada"}


@router.delete("/especies/{id}")
def eliminar_especie(
    id: int,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Especies WHERE id_especie=%s", (id,))
    especie = cursor.fetchone()

    if not especie:
        raise HTTPException(404, "Especie no encontrada")

    cursor.execute("DELETE FROM Especies WHERE id_especie=%s", (id,))
    return {"mensaje": "Especie eliminada"}


# =========================
# ADMIN FOTOGRAFIAS
# =========================

@router.post("/fotografias")
def agregar_foto(
    datos: Fotografia,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute(
        "INSERT INTO Fotografia (url_imagen, id_especie) VALUES (%s, %s)",
        (datos.url_imagen, datos.id_especie)
    )
    return {"mensaje": "Foto agregada"}


@router.delete("/fotografias/{id}")
def eliminar_foto(
    id: int,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Fotografia WHERE id_foto=%s", (id,))
    foto = cursor.fetchone()

    if not foto:
        raise HTTPException(404, "Foto no encontrada")

    cursor.execute("DELETE FROM Fotografia WHERE id_foto=%s", (id,))
    return {"mensaje": "Foto eliminada"}


# =========================
# ADMIN COMENTARIOS
# =========================

@router.get("/comentarios")
def obtener_comentarios(
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Comentario")
    return cursor.fetchall()


@router.delete("/comentarios/{id}")
def eliminar_comentario(
    id: int,
    db = Depends(get_db),
    admin = Depends(require_admin)
):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Comentario WHERE id_comentario=%s", (id,))
    comentario = cursor.fetchone()

    if not comentario:
        raise HTTPException(404, "Comentario no encontrado")

    cursor.execute("DELETE FROM Comentario WHERE id_comentario=%s", (id,))
    return {"mensaje": "Comentario eliminado"}

@router.get("/zonas/publico")
def obtener_zonas_publico(db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute("SELECT ID, nombre_region FROM Zonas ORDER BY ID")
    return cursor.fetchall()