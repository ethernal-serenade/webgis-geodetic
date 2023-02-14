import psycopg2
import psycopg2.extras as extras
from pygeos import to_wkb, set_srid


# Create connection
def create_connection(credentials):
    conn = psycopg2.connect(**credentials)
    cur = conn.cursor()
    return [conn, cur]


# Close connection
def close_connection(conn, cur):
    conn.close()
    cur.close()


def does_table_exist(cur, name, schema):
    """
        Check if table exists in the database.
    """
    sql = f"""
        SELECT * from pg_tables where schemaname = '{schema}' and tablename  = '{name}'
    """
    cur.execute(sql)
    status = cur.fetchone()
    if status is None:
        return False
    else:
        return True


def createTableFromGDF(gdf, conn, cur, name, schema, geom_name, srid):
    """
        Create table based on geopandas dataframe.
    """
    if_exists = does_table_exist(cur, name, schema)
    if if_exists is False:

        # srid = gdf.crs.to_epsg()
        table_name = schema + "." + name

        # Create a table query for geopandas file based on the columns list
        create_table_query = 'GID SERIAL PRIMARY KEY'

        for column in gdf.columns:
            column_type = str(gdf.dtypes[column])
            if column == geom_name:
                create_table_query += f', {geom_name} GEOMETRY(GEOMETRY, {srid})'
            elif column_type.find('int') != -1:
                create_table_query += ', ' + column + ' INTEGER'
            elif column_type.find('float') != -1:
                create_table_query += ', ' + column + ' NUMERIC'
            else:
                create_table_query += ', ' + column + ' TEXT'

        # Drop Table if Exists
        drop_table_query = 'DROP TABLE IF EXISTS ' + table_name
        cur.execute(drop_table_query)

        create_table_query = 'CREATE TABLE ' + table_name + '(' + create_table_query + ')'
        cur.execute(create_table_query)
        conn.commit()


def to_postgis_using_psycopg2(gdf, conn, cur, name, schema="public", geom_name="geom", srid=4326):
    """
        Using psycopg2 to export geopandas to postgis database.
        pygeos method to_wkb is used to convert geometries to wkb(well known binary) format.
        hex=true will return Hexadecimal string of the wkb which can be stored in postgis geometry column.
        set_srid is used to set the srid of the geometries.
    """
    if geom_name not in gdf.columns:
        gdf = gdf.rename(columns={gdf.geometry.name: geom_name}).set_geometry(geom_name, crs=gdf.crs)

    createTableFromGDF(gdf, conn, cur, name, schema, geom_name, srid)

    # srid = gdf.crs.to_epsg()

    # convert geom to wkb hex string
    geom = to_wkb(
        set_srid(gdf[geom_name].values.data, srid=srid), hex=True, include_srid=True
    )
    gdf[geom_name] = geom
    tuples = [tuple(x) for x in gdf.to_numpy()]
    cols = ','.join(list(gdf.columns))
    query = "INSERT INTO %s(%s) VALUES %%s" % (name, cols)
    extras.execute_values(cur, query, tuples)
    conn.commit()
