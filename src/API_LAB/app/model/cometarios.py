from pydantic import BaseModel, Field
from datetime import date

class Comentario(BaseModel):
    Contenido: str = Field(..., min_length=5)
    Fecha_publicacion: date
    ID_usuario: int = Field(..., gt=0)
    ID_zona: int = Field(..., gt=0)
    ID_estatus: int = Field(..., gt=0)
