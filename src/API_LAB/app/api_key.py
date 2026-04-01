import os
from fastapi import Header, HTTPException
from dotenv import load_dotenv

load_dotenv()
api_keys_env = os.getenv("API_KEYS")

if not api_keys_env:
    raise ValueError("No se encontró API_KEYS en el archivo .env")

API_KEYS = dict(item.split(":") for item in api_keys_env.split(","))


def get_user_by_key(x_api_key: str):
    """
    Devuelve el usuario asociado a la API key
    """
    for user, key in API_KEYS.items():
        if key == x_api_key:
            return user
    return None


def require_api_key(x_api_key: str = Header(None)):
    """
    Permite acceso a cualquier usuario
    """

    if not x_api_key:
        raise HTTPException(
            status_code=401,
            detail="Falta header X-API-Key"
        )

    user = get_user_by_key(x_api_key)

    if not user:
        raise HTTPException(
            status_code=403,
            detail="API key inválida"
        )

    return user


def require_admin(x_api_key: str = Header(None)):
    """
    Solo admin puede entrar
    """

    if not x_api_key:
        raise HTTPException(
            status_code=401,
            detail="Falta header X-API-Key"
        )

    user = get_user_by_key(x_api_key)

    if not user:
        raise HTTPException(
            status_code=403,
            detail="API key inválida"
        )

    if user != "admin":
        raise HTTPException(
            status_code=403,
            detail="Solo admin puede acceder"
        )

    return user