from fastapi import APIRouter, Depends, HTTPException
from app.database import get_db
from app.api_key import require_api_key
from app.model.cometarios import Comentario

router = APIRouter(prefix="/comentarios", tags=["Comentarios"])


@router.get("/")
def obtener_comentarios(db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Comentario")
    return cursor.fetchall()


@router.get("/{id}")
def obtener_comentario(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Comentario WHERE ID = %s", (id,))
    comentario = cursor.fetchone()
    if not comentario:
        raise HTTPException(status_code=404, detail="Comentario no encontrado")
    return comentario


@router.get("/zona/{id_zona}")
def comentarios_por_zona(id_zona: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Comentario WHERE ID_zona = %s", (id_zona,))
    return cursor.fetchall()


@router.post("/")
def crear_comentario(datos: Comentario, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute(
        """
        INSERT INTO Comentario (Contenido, Fecha_publicacion, ID_usuario, ID_zona, ID_estatus)
        VALUES (%s, %s, %s, %s, %s)
        """,
        (datos.Contenido, datos.Fecha_publicacion, datos.ID_usuario,
         datos.ID_zona, datos.ID_estatus)
    )
    return {"mensaje": "Comentario creado correctamente", "id": cursor.lastrowid}


@router.delete("/{id}")
def eliminar_comentario(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Comentario WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Comentario no encontrado")
    cursor.execute("DELETE FROM Comentario WHERE ID = %s", (id,))
    return {"mensaje": "Comentario eliminado correctamente"}
