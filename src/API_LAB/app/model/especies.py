from pydantic import BaseModel, Field
from typing import Optional

class Especie(BaseModel):
    Nombre_comun: str = Field(..., min_length=2, max_length=50)
    nombre_cientifico: str = Field(..., min_length=3, max_length=100)
    tipo: int = Field(..., gt=0)
    id_familia: int = Field(..., gt=0)
    id_zonas: int = Field(..., gt=0)
    id_estado_conservacion: int = Field(..., gt=0)

class EspecieActualizar(BaseModel):
    Nombre_comun: Optional[str] = Field(None, min_length=2, max_length=50)
    nombre_cientifico: Optional[str] = Field(None, min_length=3, max_length=100)
    tipo: Optional[int] = Field(None, gt=0)
    id_familia: Optional[int] = Field(None, gt=0)
    id_zonas: Optional[int] = Field(None, gt=0)
    id_estado_conservacion: Optional[int] = Field(None, gt=0)