import os

class Config:
    SECRET_KEY = os.getenv("SECRET_KEY", "dev-secret-change-me-123")

    DB_HOST = os.getenv("DB_HOST", "127.0.0.1")
    DB_PORT = int(os.getenv("DB_PORT", "3306"))
    DB_USER = os.getenv("DB_USER", "root")
    DB_PASS = (os.getenv("DB_PASS") or "").strip()
    DB_NAME = os.getenv("DB_NAME", "florayfauna")

    SQLALCHEMY_DATABASE_URI = (
        f"mysql+pymysql://{DB_USER}:{DB_PASS}@{DB_HOST}:{DB_PORT}/{DB_NAME}"
    )

    SQLALCHEMY_TRACK_MODIFICATIONS = False
