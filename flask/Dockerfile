FROM python:latest
WORKDIR /app
RUN pip install --no-cache-dir --upgrade pip
COPY requirements.txt /tmp/requirements.txt
RUN pip install --no-cache-dir -r /tmp/requirements.txt
CMD ["gunicorn", "-b", "0.0.0.0:5000", "app:app"]
