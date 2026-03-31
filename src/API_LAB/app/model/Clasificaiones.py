from pydantic import BaseModel, Field

class Tipo(BaseModel):
    tipo: str = Field(..., min_length=3, max_length=50)

class Familia(BaseModel):
    nombre_familia: str = Field(..., min_length=3, max_length=50)

class EstadoConservacion(BaseModel):
    categoria: str = Field(..., min_length=3, max_length=50)

class Estatus(BaseModel):
    estatus: str = Field(..., min_length=3, max_length=20)