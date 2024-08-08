import pyodbc, json, sys

# set up mdb constants
param_device = str(sys.argv[2])
param_ip = str(sys.argv[3])
if param_device == 'VIRDIAC4000':
    MDB = 'C:/mdb/UNIS.mdb'
    #MDB = '\\\\'+param_ip+'\\mdb\\UNIS.mdb'
    #MDB = 'C:/Program Files (x86)/UNIS/UNIS.mdb'
    DRV = '{Microsoft Access Driver (*.mdb)}'
    PWD = 'unisamho'
elif param_device == 'ZKTeco':
    MDB = 'C:/mdb/Access.mdb'
    #MDB = '\\\\'+param_ip+'\\mdb\\Access.mdb'
    #MDB = 'C:/Program Files (x86)/ZKTeco/ZKAccess3.5/Access.mdb'
    DRV = '{Microsoft Access Driver (*.mdb)}'
    PWD = ''
else:
    MDB = ''
    DRV = ''
    PWD = ''

try:
    # print(MDB);
    # connect to db
    mdb_con = pyodbc.connect('DRIVER={};DBQ={};PWD={}'.format(DRV,MDB,PWD))
    mdb_cur = mdb_con.cursor()

    param = sys.argv[1]

    # run a query and get the results 
    SQL = param.replace("|", " ");
    rows = mdb_cur.execute(SQL).fetchall()

    columns = [column[0] for column in mdb_cur.description]
    #print(rows,columns)
    
    mdb_cur.close() 
    mdb_con.close()

    #query_placeholders = ', '.join(['%s'] * len(columns))
    #query_columns = ', '.join(columns)

    #insert_query = ''' INSERT INTO tEnter (%s) VALUES (%s) ''' %(query_columns, query_placeholders)

    json_data=[]
    for result in rows:
        json_data.append(dict(zip(columns,result)))
    json.dumps(json_data)
    
    print(json_data);
    
except pyodbc.Error as ex:
    sqlstate = ex.args[1]
    print(sqlstate);
