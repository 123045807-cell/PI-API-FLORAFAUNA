import requests

API_URL = "http://api:8000"
HEADERS_USER  = {"x-api-key": "USER123"}
HEADERS_ADMIN = {"x-api-key": "MASTER999"}


def _get(endpoint, headers=HEADERS_USER):
    try:
        r = requests.get(f"{API_URL}{endpoint}", headers=headers, timeout=5)
        r.raise_for_status()
        return r.json()
    except Exception:
        return None


def _post(endpoint, data, headers=HEADERS_USER):
    try:
        r = requests.post(f"{API_URL}{endpoint}", json=data, headers=headers, timeout=5)
        r.raise_for_status()
        return r.json()
    except Exception:
        return None


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

# ── Usuarios ──────────────────────────────────────────────────
def get_usuario(id):
    return _get(f"/usuarios/{id}")

def crear_usuario(datos):
    return _post("/usuarios", datos)
