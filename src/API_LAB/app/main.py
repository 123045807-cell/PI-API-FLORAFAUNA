from fastapi import FastAPI
from dotenv import load_dotenv
from app.router import usuarios, comentarios, consejos, fichas
from app.router.Admin import router as admin_router
from fastapi.middleware.cors import CORSMiddleware

load_dotenv()

app = FastAPI(
    title="FloraFauna API",
    version="1.0"
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/health")
def health():
    return {"ok": True}

@app.get("/")
def home():
    return {"message": "FloraFauna API funcionando"}

app.include_router(usuarios.router)
app.include_router(admin_router)
app.include_router(comentarios.router)
app.include_router(consejos.router)
app.include_router(fichas.router)