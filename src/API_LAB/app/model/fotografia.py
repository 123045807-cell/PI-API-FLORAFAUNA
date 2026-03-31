from pydantic import BaseModel, Field

class Fotografia(BaseModel):
    url_imagen: str = Field(..., min_length=5, max_length=200)
    id_especie: int = Field(..., gt=0)