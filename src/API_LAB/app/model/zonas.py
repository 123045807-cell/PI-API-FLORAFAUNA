from pydantic import BaseModel, Field

class Zona(BaseModel):
    nombre_region: str = Field(..., min_length=3, max_length=500)