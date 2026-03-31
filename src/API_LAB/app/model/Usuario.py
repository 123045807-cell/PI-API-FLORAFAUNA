from pydantic import BaseModel, EmailStr, Field
from typing import Optional

class Usuario(BaseModel):
    nombre: str = Field(..., min_length=2, max_length=100)
    apellidoPaterno: str = Field(..., min_length=2, max_length=100)
    apellidoMaterno: Optional[str] = Field(None, max_length=100)
    correo: EmailStr
    contrasena: str = Field(..., min_length=6, max_length=255)


class UsuarioAct(BaseModel):
    nombre: Optional[str] = Field(None, min_length=2, max_length=100)
    apellidoPaterno: Optional[str] = Field(None, min_length=2, max_length=100)
    apellidoMaterno: Optional[str] = Field(None, max_length=100)
    correo: Optional[EmailStr]
    contrasena: Optional[str] = Field(None, min_length=6, max_length=255)
