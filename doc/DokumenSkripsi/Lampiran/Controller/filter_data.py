# -*- coding: utf-8 -*-
"""
Spyder Editor

This is a temporary script file.
"""
#mtk 1
#ind 2
#ing 3
#fis 4
#gbr 5
#pkn 6
#kim 7

import pandas as pd
#import math as m

#ftis13 -> mtk if 2
#ftis2 -> fis 3
data = pd.read_csv("ftis13.csv");


mhs = pd.DataFrame(columns=["id_user","NPM","IPK","id_jurusan","id_program_studi"])
nilai = pd.DataFrame(columns=["id_nilai","id_mata_pelajaran","id_user","101","102","111","112","AVG"])

def generateCSV(mhs, nilai, count):
    size= data.shape[0]
    batas = int(size/(4*count))
    
    id_user=1529  #pake counter
    id_nilai=3609 #pake counter
    
    ipa = 1
    ips = 2

    
    for idx in range(batas):
        idx = idx*(4*count)
        
        
        #input untuk table mahasiswa
        npm = str(data.iloc[idx][0])
        id_prodi = data.iloc[idx][1]
        #id_fakultas = id_prodi/10
        #id_fakultas = m.floor(id_fakultas/10)
        id_jurusan = ipa
        for i in range(7,18):
            ipk = data.iloc[idx][i]
            if(ipk!=0 and data.iloc[idx][i+1]==0):
                break
            
        mhs = mhs.append({"id_user":id_user, "NPM":npm, "IPK":ipk, "id_jurusan":id_jurusan,
                          "id_program_studi":id_prodi}, ignore_index=True)
    
        #input untuk tabel nilai
        
        for i in range(0,count):
            row = idx+i
            id_mp = data.iloc[row][3]
            m_101 = (data.iloc[row+0*count][5]/20)-1
            m_102 = (data.iloc[row+1*count][5]/20)-1
            m_111 = (data.iloc[row+2*count][5]/20)-1
            m_112 = (data.iloc[row+3*count][5]/20)-1
            #print(row,"\n")
            
            avg = (m_101+m_102+m_111+m_112)/4
            
            #masukin ke nilai
            nilai = nilai.append({"id_nilai":id_nilai, "id_mata_pelajaran":id_mp, "id_user":id_user,
                                "101":m_101, "102":m_102, "111":m_111, "112":m_112, "AVG":avg}, 
                                ignore_index=True)
            
            id_nilai+=1
        id_user+=1     
    return mhs, nilai
    
rest = generateCSV(mhs, nilai, 2)    

mhs = rest[0]
mhs.to_csv(r"C:\Users\anugrahjaya1\Downloads\Data\7 FTIS\new_ftis_mhs13.csv", index=None, header=True)

nilai= rest[1]
nilai.to_csv(r"C:\Users\anugrahjaya1\Downloads\Data\7 FTIS\new_ftis_nilai13.csv", index=None, header=True)
