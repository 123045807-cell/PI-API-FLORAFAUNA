from fastapi import APIRouter, Depends, HTTPException
from app.database import get_db
from app.api_key import require_api_key
from app.model.cometarios import Comentario, ComentarioEdit

router = APIRouter(prefix="/comentarios", tags=["Comentarios"])


@router.get("/")
def obtener_comentarios(db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("""
        SELECT c.ID, c.Contenido, c.Fecha_publicacion, c.ID_usuario,
               u.nombre, z.nombre_region,
               COUNT(l.id) as likes
        FROM Comentario c
        LEFT JOIN Usuarios u ON c.ID_usuario = u.id
        LEFT JOIN Zonas z ON c.ID_zona = z.ID
        LEFT JOIN Likes l ON c.ID = l.id_comentario
        GROUP BY c.ID, c.Contenido, c.Fecha_publicacion, c.ID_usuario,
                 u.nombre, z.nombre_region
        ORDER BY c.Fecha_publicacion DESC
    """)
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
    cursor.execute("""
        SELECT c.ID, c.Contenido, c.Fecha_publicacion, c.ID_usuario,
               u.nombre, z.nombre_region,
               COUNT(l.id) as likes
        FROM Comentario c
        LEFT JOIN Usuarios u ON c.ID_usuario = u.id
        LEFT JOIN Zonas z ON c.ID_zona = z.ID
        LEFT JOIN Likes l ON c.ID = l.id_comentario
        WHERE c.ID_zona = %s
        GROUP BY c.ID, c.Contenido, c.Fecha_publicacion, c.ID_usuario,
                 u.nombre, z.nombre_region
        ORDER BY c.Fecha_publicacion DESC
    """, (id_zona,))
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


@router.post("/like/{id}")
def like_comentario(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Comentario WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Comentario no encontrado")
    cursor.execute("INSERT INTO Likes (id_comentario) VALUES (%s)", (id,))
    cursor.execute("SELECT COUNT(*) as total FROM Likes WHERE id_comentario = %s", (id,))
    total = cursor.fetchone()["total"]
    return {"mensaje": "Like agregado", "likes": total}


@router.post("/editar/{id}")
def editar_comentario(id: int, datos: ComentarioEdit, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Comentario WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Comentario no encontrado")
    cursor.execute("UPDATE Comentario SET Contenido = %s WHERE ID = %s", (datos.contenido, id))
    return {"mensaje": "Comentario actualizado"}


@router.delete("/{id}")
def eliminar_comentario(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM Comentario WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Comentario no encontrado")
    cursor.execute("DELETE FROM Likes WHERE id_comentario = %s", (id,))
    cursor.execute("DELETE FROM Comentario WHERE ID = %s", (id,))
    return {"mensaje": "Comentario eliminado correctamente"}