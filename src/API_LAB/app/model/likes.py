from pydantic import BaseModel, Field

class Like(BaseModel):
    id_comentario: int = Field(..., gt=0)
    id_usuario: int = Field(..., gt=0)