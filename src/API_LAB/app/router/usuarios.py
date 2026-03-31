from fastapi import APIRouter, Depends, HTTPException
from app.database import get_db
from app.api_key import require_api_key
from app.model.Usuario import Usuario, UsuarioAct

router = APIRouter(prefix="/usuarios", tags=["Usuarios"])


@router.get("/")
def obtener_usuarios(db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Usuarios")
    return cursor.fetchall()


@router.get("/{id}")
def obtener_usuario(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT * FROM Usuarios WHERE id = %s", (id,))
    usuario = cursor.fetchone()
    if not usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    return usuario


@router.post("/")
def crear_usuario(datos: Usuario, db=Depends(get_db)):
    cursor = db.cursor()
    cursor.execute("SELECT id FROM Usuarios WHERE correo = %s", (datos.correo,))
    if cursor.fetchone():
        raise HTTPException(status_code=400, detail="El correo ya está registrado")
    cursor.execute(
        """
        INSERT INTO Usuarios (nombre, apellidoPaterno, apellidoMaterno, correo, contrasena)
        VALUES (%s, %s, %s, %s, %s)
        """,
        (datos.nombre, datos.apellidoPaterno, datos.apellidoMaterno,
         datos.correo, datos.contrasena)
    )
    return {"mensaje": "Usuario creado correctamente", "id": cursor.lastrowid}


@router.put("/{id}")
def actualizar_usuario(id: int, datos: Usuario, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT id FROM Usuarios WHERE id = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Usuario no encontrado")

    # Verificar que el correo no lo use OTRO usuario
    cursor.execute("SELECT id FROM Usuarios WHERE correo = %s AND id != %s", (datos.correo, id))
    if cursor.fetchone():
        raise HTTPException(status_code=400, detail="El correo ya está en uso por otro usuario")

    cursor.execute(
        """
        UPDATE Usuarios
        SET nombre=%s, apellidoPaterno=%s, apellidoMaterno=%s, correo=%s, contrasena=%s
        WHERE id=%s
        """,
        (datos.nombre, datos.apellidoPaterno, datos.apellidoMaterno,
         datos.correo, datos.contrasena, id)
    )
    return {"mensaje": "Usuario actualizado completamente"}


@router.patch("/{id}")
def actualizar_parcial_usuario(id: int, datos: UsuarioAct, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT id FROM Usuarios WHERE id = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Usuario no encontrado")

    campos = []
    valores = []
    if datos.nombre is not None:
        campos.append("nombre=%s"); valores.append(datos.nombre)
    if datos.apellidoPaterno is not None:
        campos.append("apellidoPaterno=%s"); valores.append(datos.apellidoPaterno)
    if datos.apellidoMaterno is not None:
        campos.append("apellidoMaterno=%s"); valores.append(datos.apellidoMaterno)
    if datos.correo is not None:
        # Verificar que el correo no lo use OTRO usuario
        cursor.execute("SELECT id FROM Usuarios WHERE correo = %s AND id != %s", (datos.correo, id))
        if cursor.fetchone():
            raise HTTPException(status_code=400, detail="El correo ya está en uso por otro usuario")
        campos.append("correo=%s"); valores.append(datos.correo)
    if datos.contrasena is not None:
        campos.append("contrasena=%s"); valores.append(datos.contrasena)

    valores.append(id)
    cursor.execute(f"UPDATE Usuarios SET {', '.join(campos)} WHERE id=%s", valores)
    return {"mensaje": "Usuario actualizado parcialmente"}


@router.delete("/{id}")
def eliminar_usuario(id: int, db=Depends(get_db), user=Depends(require_api_key)):
    cursor = db.cursor()
    cursor.execute("SELECT id FROM Usuarios WHERE id = %s", (id,))
    if not cursor.fetchone():
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    
    # Borrar dependencias primero
    cursor.execute("DELETE FROM Comentario WHERE ID_usuario=%s", (id,))
    cursor.execute("DELETE FROM Likes WHERE ID_usuario=%s", (id,))
    
    cursor.execute("DELETE FROM Usuarios WHERE id=%s", (id,))
    return {"mensaje": "Usuario eliminado correctamente"}