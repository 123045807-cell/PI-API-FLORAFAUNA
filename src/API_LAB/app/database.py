import os
import pymysql
from dotenv import load_dotenv

load_dotenv()

def db_connect():
    return pymysql.connect(
        host=os.getenv("DB_HOST"),
        port=int(os.getenv("DB_PORT", "3306")),
        user=os.getenv("DB_USER"),
        password=os.getenv("DB_PASS"),
        database=os.getenv("DB_NAME"),
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=True,
    )

# Dependencia para FastAPI
def get_db():
    db = db_connect()
    try:
        yield db
    finally:
        db.close()