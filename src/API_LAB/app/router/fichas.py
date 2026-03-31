from fastapi import APIRouter, Depends, HTTPException
from app.database import get_db
from app.api_key import require_api_key, require_admin
from app.model.especies import Especie, EspecieActualizar
from app.model.fotografia import Fotografia

router = APIRouter(prefix="/fichas", tags=["Fichas"])


# ─── Especies ────────────────────────────────────────────────

@router.get("/especies")
def obtener_especies(db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("""
        SELECT
            e.ID,
            e.Nombre_comun,
            e.nombre_cientifico,
            e.tipo,
            f.nombre_familia AS familia,
            e.id_zonas,
            e.id_estado_conservacion
        FROM Especies e
        LEFT JOIN Familia f ON e.id_familia = f.ID
    """)
    return cursor.fetchall()


@router.get("/especies/{id}")
def obtener_especie(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("""
        SELECT
            e.ID,
            e.Nombre_comun,
            e.nombre_cientifico,
            e.tipo,
            f.nombre_familia AS familia,
            e.id_zonas,
            e.id_estado_conservacion
        FROM Especies e
        LEFT JOIN Familia f ON e.id_familia = f.ID
        WHERE e.ID = %s
    """, (id,))
    especie = cursor.fetchone()
    if not especie:
        raise HTTPException(status_code=404, detail="Especie no encontrada")
    return especie


@router.get("/especies/zona/{id_zona}")
def especies_por_zona(id_zona: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("""
        SELECT
            e.ID,
            e.Nombre_comun,
            e.nombre_cientifico,
            e.tipo,
            f.nombre_familia AS familia,
            e.id_zonas,
            e.id_estado_conservacion
        FROM Especies e
        LEFT JOIN Familia f ON e.id_familia = f.ID
        WHERE e.id_zonas = %s
    """, (id_zona,))
    return cursor.fetchall()


@router.post("/especies")
def crear_especie(datos: Especie, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute(
        """
        INSERT INTO Especies (Nombre_comun, nombre_cientifico, tipo, id_familia, id_zonas, id_estado_conservacion)
        VALUES (%s, %s, %s, %s, %s, %s)
        """,
        (datos.Nombre_comun, datos.nombre_cientifico, datos.tipo,
         datos.id_familia, datos.id_zonas, datos.id_estado_conservacion)
    )
    return {"mensaje": "Especie creada correctamente", "id": cursor.lastrowid}


@router.patch("/especies/{id}")
def actualizar_especie(id: int, datos: EspecieActualizar, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Especies WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Especie no encontrada")

    campos = []
    valores = []
    if datos.Nombre_comun is not None:
        campos.append("Nombre_comun=%s"); valores.append(datos.Nombre_comun)
    if datos.nombre_cientifico is not None:
        campos.append("nombre_cientifico=%s"); valores.append(datos.nombre_cientifico)
    if datos.tipo is not None:
        campos.append("tipo=%s"); valores.append(datos.tipo)
    if datos.id_familia is not None:
        campos.append("id_familia=%s"); valores.append(datos.id_familia)
    if datos.id_zonas is not None:
        campos.append("id_zonas=%s"); valores.append(datos.id_zonas)
    if datos.id_estado_conservacion is not None:
        campos.append("id_estado_conservacion=%s"); valores.append(datos.id_estado_conservacion)

    if not campos:
        raise HTTPException(status_code=400, detail="No se enviaron campos para actualizar")

    valores.append(id)
    cursor.execute(f"UPDATE Especies SET {', '.join(campos)} WHERE ID=%s", valores)
    return {"mensaje": "Especie actualizada correctamente"}


@router.delete("/especies/{id}")
def eliminar_especie(id: int, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Especies WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Especie no encontrada")
    cursor.execute("DELETE FROM Especies WHERE ID = %s", (id,))
    return {"mensaje": "Especie eliminada correctamente"}


# ─── Fotografías ─────────────────────────────────────────────

@router.get("/fotografias/{id_especie}")
def obtener_fotos(id_especie: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Fotografia WHERE id_especie = %s", (id_especie,))
    return cursor.fetchall()


@router.post("/fotografias")
def agregar_foto(datos: Fotografia, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute(
        "INSERT INTO Fotografia (url_imagen, id_especie) VALUES (%s, %s)",
        (datos.url_imagen, datos.id_especie)
    )
    return {"mensaje": "Fotografía agregada correctamente", "id": cursor.lastrowid}


@router.delete("/fotografias/{id}")
def eliminar_foto(id: int, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Fotografia WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Fotografía no encontrada")
    cursor.execute("DELETE FROM Fotografia WHERE ID = %s", (id,))
    return {"mensaje": "Fotografía eliminada correctamente"}