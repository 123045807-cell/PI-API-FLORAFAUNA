import os
import requests

API_URL = os.getenv("API_URL", "http://api:8000").rstrip("/")
API_URL_FALLBACKS = [API_URL, "http://localhost:8000"]
HEADERS_USER  = {"x-api-key": "USER123"}
HEADERS_ADMIN = {"x-api-key": "MASTER999"}


def _request(method, endpoint, json=None, headers=HEADERS_USER):
    for base_url in API_URL_FALLBACKS:
        try:
            url = f"{base_url}{endpoint}"
            response = requests.request(method, url, json=json, headers=headers, timeout=5)
            response.raise_for_status()
            return response.json()
        except Exception:
            continue
    return None


def _get(endpoint, headers=HEADERS_USER):
    return _request("GET", endpoint, headers=headers)


def _post(endpoint, data, headers=HEADERS_USER):
    return _request("POST", endpoint, json=data, headers=headers)


def _delete(endpoint, headers=HEADERS_USER):
    return _request("DELETE", endpoint, headers=headers)


# ── Especies ──────────────────────────────────────────────────
def get_especies():
    return _get("/fichas/especies") or []

def get_especies_por_zona(id_zona):
    return _get(f"/fichas/especies/zona/{id_zona}") or []

def get_especie(id):
    return _get(f"/fichas/especies/{id}")

# ── Fotografías ───────────────────────────────────────────────
def get_fotos_especie(id_especie):
    return _get(f"/fichas/fotografias/{id_especie}") or []

# ── Zonas ─────────────────────────────────────────────────────
def get_zonas():
    return _get("/admin/zonas", headers=HEADERS_ADMIN) or []

# ── Consejos ──────────────────────────────────────────────────
def get_consejos():
    return _get("/consejos") or []

def get_consejos_por_zona(id_zona):
    return _get(f"/consejos/zona/{id_zona}") or []

# ── Comentarios ───────────────────────────────────────────────
def get_comentarios():
    return _get("/comentarios") or []

def get_comentarios_por_zona(id_zona):
    return _get(f"/comentarios/zona/{id_zona}") or []

def crear_comentario(datos):
    return _post("/comentarios", datos)

def like_comentario(id):
    return _post(f"/comentarios/like/{id}", {})

def editar_comentario(id, contenido):
    return _post(f"/comentarios/editar/{id}", {"contenido": contenido})

def eliminar_comentario(id):
    resultado = _delete(f"/comentarios/{id}")
    return resultado is not None

# ── Usuarios ──────────────────────────────────────────────────
def get_usuario(id):
    return _get(f"/usuarios/{id}")

def crear_usuario(datos):
    return _post("/usuarios", datos)

def login_usuario(correo, contrasena):
    return _post("/usuarios/login", {"correo": correo, "contrasena": contrasena})