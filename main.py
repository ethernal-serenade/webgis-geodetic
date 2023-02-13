import uvicorn
import shutil
import os
from dotenv import load_dotenv
from fastapi import FastAPI, Form, File, UploadFile
from starlette.middleware.cors import CORSMiddleware
from function.main import create_connection, close_connection, to_postgis_using_psycopg2
import geopandas as gpd
load_dotenv()

app = FastAPI()
origins = [
    "http://localhost",
    "http://localhost:81",
    # "http://gisvn.info",
    # "http://upload.gisvn.info"
]
app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


def remove_contents_folder(folder):
    filelist = [file for file in os.listdir(folder)]
    for f in filelist:
        os.remove(os.path.join(folder, f))

    os.removedirs(folder)


@app.post('/upload')
async def upload_file(name: str = Form(...), srid: str = Form(...), file: UploadFile = File(...)):
    if not os.path.exists('zip'):
        os.makedirs('zip')

    if not os.path.exists('unzip'):
        os.makedirs('unzip')

    try:
        if 'zip' in file.filename:
            file_location = 'zip/' + file.filename

            file_true_name = file.filename.split('.zip')[0]
            if name != 'null':
                table_name = name.lower()
            else:
                table_name = file_true_name.lower()
            table_name = ''.join(e for e in table_name if e.isalnum())

            if srid != 'null':
                srid_value = int(srid)
            else:
                srid_value = int('4326')

            with open(file_location, "wb+") as file_object:
                file_object.write(file.file.read())

            # Process Zip file
            shutil.unpack_archive(file_location, 'unzip')
            if os.path.exists('unzip/' + file_true_name + '.shp'):
                credentials = {"user": os.getenv("POSTGRES_USER"),
                               "password": os.getenv("POSTGRES_PASSWORD"),
                               "host": os.getenv("POSTGRES_HOST"),
                               "port": os.getenv("POSTGRES_PORT"),
                               "database": os.getenv("POSTGRES_DB")}
                try:
                    [conn, cur] = create_connection(credentials)
                    gdf = gpd.read_file('unzip/' + file_true_name + '.shp')
                    to_postgis_using_psycopg2(gdf, conn, cur, table_name, "public", geom_name="geom", srid=srid_value)
                    close_connection(conn, cur)

                    # Remove Zip file
                    remove_contents_folder('zip')
                    remove_contents_folder('unzip')

                    return {"message": "Success", "status": 200}
                except Exception as e:
                    return {"message": e, "status": 401}
            else:
                return {"message": "Zip file dose not have '.shp' file", "status": 401}
        else:
            return {"message": "Format file is not '.zip'", "status": 401}

    except Exception as e:
        return {"message": e, "status": 401}


if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=5000)
