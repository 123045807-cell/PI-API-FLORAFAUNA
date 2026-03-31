from fastapi import APIRouter, Depends, HTTPException
from app.database import get_db
from app.api_key import require_api_key, require_admin
from app.model.consejos import Consejo

router = APIRouter(prefix="/consejos", tags=["Consejos"])


@router.get("/")
def obtener_consejos(db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM consejos")
    return cursor.fetchall()


@router.get("/{id}")
def obtener_consejo(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM consejos WHERE ID = %s", (id,))
    consejo = cursor.fetchone()
    if not consejo:
        raise HTTPException(status_code=404, detail="Consejo no encontrado")
    return consejo


@router.get("/zona/{id_zona}")
def consejos_por_zona(id_zona: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM consejos WHERE zona = %s", (id_zona,))
    return cursor.fetchall()


@router.post("/")
def crear_consejo(datos: Consejo, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute(
        """
        INSERT INTO consejos (zona, titulo, consejo, fecha, hora)
        VALUES (%s, %s, %s, %s, %s)
        """,
        (datos.zona, datos.titulo, datos.consejo, datos.fecha, datos.hora)
    )
    return {"mensaje": "Consejo creado correctamente", "id": cursor.lastrowid}


@router.put("/{id}")
def actualizar_consejo(id: int, datos: Consejo, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM consejos WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Consejo no encontrado")
    cursor.execute(
        """
        UPDATE consejos SET zona=%s, titulo=%s, consejo=%s, fecha=%s, hora=%s
        WHERE ID=%s
        """,
        (datos.zona, datos.titulo, datos.consejo, datos.fecha, datos.hora, id)
    )
    return {"mensaje": "Consejo actualizado correctamente"}


@router.delete("/{id}")
def eliminar_consejo(id: int, db=Depends(get_db), admin=Depends(require_admin)):
    cursor = db.cursor()
    cursor.execute("SELECT ID FROM consejos WHERE ID = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Consejo no encontrado")
    cursor.execute("DELETE FROM consejos WHERE ID = %s", (id,))
    return {"mensaje": "Consejo eliminado correctamente"}
