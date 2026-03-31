from pydantic import BaseModel, Field
from datetime import date, time

class Consejo(BaseModel):
    zona: int = Field(..., gt=0)
    titulo: str = Field(..., min_length=5, max_length=300)
    consejo: str = Field(..., min_length=10)
    fecha: date
    hora: time
