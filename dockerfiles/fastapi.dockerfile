FROM python:latest

COPY . .

RUN pip install --upgrade pip
RUN python -m pip install -r requirements.txt

CMD ["python", "main.py"]
