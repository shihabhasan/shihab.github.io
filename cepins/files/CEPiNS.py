###########################################################
#    CEPiNS: Conserved Exon Prediction in Novel Species   #
###########################################################

'''Written by: Shihab Hasan, Department of Information Technology, University of Turku, Finland.'''

import  wx
import  wx.lib.filebrowsebutton as filebrowse
from Bio.Blast.Applications import NcbiblastxCommandline
import sys
import os
import subprocess
from Bio import SeqIO
from sets import Set
import time



class MyFrame(wx.Frame):
    def __init__(self, parent, id):
        wx.Frame.__init__(self, parent, id, 'CEPiNS - Conserved Exon Prediction in Novel Species', size=(550, 750))
        self.panel = wx.Panel(self, -1)

#---------------------------------------------------------------------------

        # Part-1: Preprocessing: remove alternate splicing, find orthologous
        status=self.CreateStatusBar()
        menubar=wx.MenuBar()
        first=wx.Menu()
        second=wx.Menu()

        SaveLogMenu=first.Append(wx.NewId(), "Save log...", "Save the log in a text file")
        quitMenu=first.Append(wx.NewId(), "Exit", "Close the program")

        removeAltSpliceMenu=second.Append(wx.NewId(), "Remove alternate splicing", "Self blast to remove alternative splicing")
        orthogsMenu=second.Append(wx.NewId(), "Predict Orthologs", "Get Orthologous genes from Reference & Novel Species")
        
        
        menubar.Append(first, "File")
        menubar.Append(second, "Preprocess")
        self.SetMenuBar(menubar)


        #SAVE LOG FILE
        self.Bind(wx.EVT_MENU, self.SaveLog, SaveLogMenu)

        #QUIT

        self.Bind(wx.EVT_MENU, self.Quit, quitMenu)

        #Remove alternate splicing
        self.Bind(wx.EVT_MENU, self.removeAltSplice, removeAltSpliceMenu)

        #Get orthologous gene
        self.Bind(wx.EVT_MENU, self.getOrthologs, orthogsMenu)
        


        # Part-2: Spidey Search for Exon Prediction

        label1 = wx.StaticText(self.panel, -1, 'Exon Prediction in Reference Species',(15,10),(500, -1), wx.ALIGN_CENTER)
        label1.SetForegroundColour('white')
        label1.SetBackgroundColour('blue')
        '''     genomic button              '''
        self.genomicButton = filebrowse.FileBrowseButton(self.panel, -1, pos=(40,30), size =(450, -1), labelText= "Select reference genomic file")
        
        self.refButton = filebrowse.FileBrowseButton(self.panel, -1, pos=(40,60), size =(450, -1), labelText= "Select filtered reference cDNA file")

   
        ExonPredictButton = wx.Button(self.panel, -1, label='Exon Predict', pos=(220, 110), size=(100,30))
        ExonPredictButton.SetFont(wx.Font(12, wx.FONTFAMILY_DEFAULT, wx.FONTSTYLE_NORMAL, wx.FONTWEIGHT_NORMAL))
        ExonPredictButton.SetForegroundColour('red')
        self.Bind(wx.EVT_BUTTON, self.ExonPredict, ExonPredictButton)

        label2 = wx.StaticText(self.panel, -1, 'View Result for Exon Prediction',(195,160),(-1, -1), wx.ALIGN_CENTER)
        label2.SetBackgroundColour('green')

        SpideyTableButton = wx.Button(self.panel, -1, label='Exon Predict Table', pos=(150, 190), size=(-1, -1))
        self.Bind(wx.EVT_BUTTON, self.SpideyTable, SpideyTableButton)

        ExonFastaButton = wx.Button(self.panel, -1, label='Exon Fasta File', pos=(300, 190), size=(-1, -1))
        self.Bind(wx.EVT_BUTTON, self.ExonFasta, ExonFastaButton)


        # Part-3: Exon prediction for new species


        label3 = wx.StaticText(self.panel, -1, 'Exon Prediction for Novel Species',(15,235),(500, -1), wx.ALIGN_CENTER)
        label3.SetForegroundColour('white')
        label3.SetBackgroundColour('blue')
        
        self.novelButton = filebrowse.FileBrowseButton(self.panel, -1, pos=(40,260), size =(450, -1), labelText= "Select novel species orthologous cDNA file")
        
        ExonPredictButton = wx.Button(self.panel, -1, label='Novel Exon Predict', pos=(200, 305), size=(150,30))
        ExonPredictButton.SetFont(wx.Font(12, wx.FONTFAMILY_DEFAULT, wx.FONTSTYLE_NORMAL, wx.FONTWEIGHT_NORMAL))
        ExonPredictButton.SetForegroundColour('red')
        self.Bind(wx.EVT_BUTTON, self.NovelExonPredict, ExonPredictButton)

        label4 = wx.StaticText(self.panel, -1, 'View Result for Novel Exon Prediction',(195,350),(-1, -1), wx.ALIGN_CENTER)
        label4.SetBackgroundColour('green')

        NovelTableButton = wx.Button(self.panel, -1, label='Novel Exon Predict Table', pos=(150, 380), size=(-1, -1))
        self.Bind(wx.EVT_BUTTON, self.NovelTable, NovelTableButton)

        NovelFastaButton = wx.Button(self.panel, -1, label='Novel Exon Fasta File', pos=(300, 380), size=(-1, -1))
        self.Bind(wx.EVT_BUTTON, self.NovelExon, NovelFastaButton)


        #........log screen..........
        label5 = wx.StaticText(self.panel, -1, 'Log Screen',(15,420),(500, -1), wx.ALIGN_CENTER)
        label5.SetForegroundColour('white')
        label5.SetBackgroundColour('gray')
        self.logger= wx.TextCtrl(self.panel, -1, pos=(15,445), size=(505,215),style=wx.TE_MULTILINE | wx.TE_READONLY)


     
#---------FOR PREPROCESS--------------------------------------------------------

    def SaveLog(self, event):
        if self.refButton.GetValue()!="":
            inFile = self.refButton.GetValue()
        else:
            inFile=""
        self.logger.SaveFile(inFile+"_CEPiNS_log.txt")
        self.logger.AppendText("CEPiNS log file saved to: "+inFile+"_CEPiNS_log.txt\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("CEPiNS log file saved to: "+inFile+"_CEPiNS_log.txt")
        
        

    def Quit(self, event):
        self.Close()


    def removeAltSplice(self, event):
        dlg = wx.FileDialog(self, message="Choose file", defaultDir=os.getcwd(), defaultFile="", style=wx.OPEN | wx.CHANGE_DIR)
        if dlg.ShowModal() == wx.ID_OK:
            self.globalFile1 = dlg.GetPath()
        dlg.Destroy()
        start_time = time.time()
        self.logger.AppendText("Start Time:  "+str(time.asctime())+"\n")

        blast_db_exe = r"makeblastdb.exe"
        blast_file = self.globalFile1
        cline1 = blast_db_exe+" -in "+blast_file+" -dbtype nucl"
        return_code1 = subprocess.call(str(cline1), shell=(sys.platform!="win32"))
        
        blast_exe = r"blastn.exe"
        blast_db=self.globalFile1
        blast_query=self.globalFile1
        cline2 = NcbiblastxCommandline(cmd=blast_exe, query=blast_query, db=blast_db, evalue=0.00001, outfmt=10, out=self.globalFile1+"_selfBlast.txt")
        return_code2 = subprocess.call(str(cline2), shell=(sys.platform!="win32"))
        self.logger.AppendText("Self BLAST completed\nSelf BLAST result saved to: "+self.globalFile1+"_selfBlast.txt\n")

        evalue = 0.000001
        perID = 95
        alignlenbp = 100

        fastafile = self.globalFile1

        txtfile = open(self.globalFile1+"_selfBlast.txt", "r")


        ''' Writing a new fasta file with each headering having length added to it
        this also gives a unque header for replicate genes and an indication that this file 
        has been worked up on since the length is there
        '''
        outname = "uniq.geneIDs.length.txt"
        outFile=open(outname, "w")
        outFile.write(str("seqID"+"\t"+"bp_length"+"\n"))
        outname2 = "InputFasta_length_added.fas"
        outFile2 = open(outname2, "w")
   
        seq1=SeqIO.parse(fastafile, "fasta")
        for i in seq1:
            rhead = i.description
            nhead = rhead.split(";")
            pnhead = nhead[0].split(" ")
            outFile.write(str(pnhead[0])+"\t"+str(len(i.seq))+"\n")
            outFile2.write(str(">"+str(pnhead[0])+";"+str(len(i.seq))+"\n"+i.seq+"\n"))
        outFile.close() 
        outFile2.close()

        
        def countDuplicatesInList(dupedList):
           uniqueSet = Set(item for item in dupedList)
           return [(dupedList.count(item)) for item in uniqueSet]


        ''' making dictionary of the IDs and their length '''
        my_dict={}
        for line in open("uniq.geneIDs.length.txt"):
                if 'seqID' in line:
                    continue
                line=line.strip()

                r = line.replace("|","\t")
                l = r.split("\t")
                nl =l[0].split(";")
                fastaID = nl[0]
                fastaLen = l[1]
                my_dict.setdefault(fastaID, fastaLen)
        startlen = len(my_dict)
        ''' Blast table parsing '''

        pID="null"

        IDs = []
        outname3 = "uniq.geneIDs.length.txt"
        outFile3=open(outname3, "r")   
        for line in txtfile:   
            line=line.strip()
            l = line.split(",")
            pqID = l[0]
            spqID = pqID.split("|")
            qID =spqID[0]
            psID = l[1]
            spsID = psID.split("|")
            sID = spsID[-1]
            if float(l[-2]) <= evalue and float(l[3]) >= alignlenbp and qID != sID and float(l[2]) >= perID: # taking > 95% identity
                IDs.append(qID)
                if my_dict.has_key(qID) and my_dict.has_key(sID):
                    if my_dict[qID] > my_dict[sID]:
                        del my_dict[sID]
                    elif my_dict[qID] < my_dict[sID]:
                        del my_dict[qID]
                    elif my_dict[qID] == my_dict[sID]:
                        del my_dict[sID]
        outFile3.close()
        txtfile.close()

        ''' assessing whether there has been enough descriptions run in the blast to caputre all of the isoforms & duplicates'''
        IDcounts = countDuplicatesInList(IDs)
        sIDcounts= sorted(IDcounts, reverse=True)       
        filtIDs= (my_dict.keys())[:]
        self.logger.AppendText("%i total IDs" % startlen+"\n")
        self.logger.AppendText("%i IDs remained after filtering" % len(filtIDs)+"\n")
        dif = startlen - len(filtIDs)
        self.logger.AppendText("%i number of alt spliced sequences were filtered out" % dif+"\n")

        self.logger.AppendText("generating filtered fasta file...\n")
        outFile=open(self.globalFile1+"_filtered.fasta", "w")
        
        seq1=SeqIO.parse(self.globalFile1, "fasta")
        for i in seq1:  
            head = i.description
            phead = head.split(" ")
            if phead[0] in filtIDs:      
                outFile.write(str(">"+phead[0]+"\n"+i.seq+"\n"))

        outFile.close() 
        records = list(SeqIO.parse(self.globalFile1+"_filtered.fasta", "fasta"))
        self.logger.AppendText("Saved %i sequences in new filtered fasta file" % len(records)+"\n")
        self.logger.AppendText("New filtered fasta file saved to: "+self.globalFile1+"_filtered.fasta\n")
        self.logger.AppendText("Finish Time:  "+str(time.asctime())+"\n")
        self.logger.AppendText("Time elapsed:  "+str(time.time() - start_time)+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Alternate splicing removed\nNew filtered fasta file saved to: "+self.globalFile1+"_filtered.fasta")



    def getOrthologs(self, event):
        dlg1 = wx.FileDialog(self, message="Choose filtered Reference cDNA file", defaultDir=os.getcwd(), defaultFile="", style=wx.OPEN | wx.CHANGE_DIR)
        if dlg1.ShowModal() == wx.ID_OK:
            filtRefFile = dlg1.GetPath()
        dlg1.Destroy()

        dlg2 = wx.FileDialog(self, message="Choose filtered Novel cDNA file", defaultDir=os.getcwd(), defaultFile="", style=wx.OPEN | wx.CHANGE_DIR)
        if dlg2.ShowModal() == wx.ID_OK:
            filtNovelFile = dlg2.GetPath()
        dlg2.Destroy()
        
        start_time = time.time()
        self.logger.AppendText("Orthlogous gene selection started...\n")
        self.logger.AppendText("Start Time:  "+str(time.asctime())+"\n")

        outFile1=open(filtRefFile+"_Protein.fasta", "w")
        DNAfile=SeqIO.parse(filtRefFile, "fasta")
        for record in DNAfile:
            outFile1.write(str(">"+record.description+"\n"+record.seq.translate()+"\n"))
        outFile1.close()

        outFile2=open(filtNovelFile+"_Protein.fasta", "w")
        NovelFile=SeqIO.parse(filtNovelFile, "fasta")
        for record in NovelFile:
            outFile2.write(str(">"+record.description+"\n"+record.seq.translate()+"\n"))
        outFile2.close()
        

        blast_db_exe = r"makeblastdb.exe"
        blast_file = filtRefFile+"_Protein.fasta"
        cline1 = blast_db_exe+" -in "+blast_file+" -dbtype prot"
        return_code1 = subprocess.call(str(cline1), shell=(sys.platform!="win32"))
        
        blast_exe = r"blastp.exe"
        blast_db=filtRefFile+"_Protein.fasta" 
        blast_query=filtNovelFile+"_Protein.fasta"
        cline2 = NcbiblastxCommandline(cmd=blast_exe, query=blast_query, db=blast_db, evalue=0.00001, outfmt=10, out=filtNovelFile+"_reciprocalBlast.txt")
        return_code2 = subprocess.call(str(cline2), shell=(sys.platform!="win32"))
        self.logger.AppendText("Query: "+filtNovelFile+"\n"+"Database: "+filtRefFile+"\n")
        self.logger.AppendText("Reciprocal BLAST result saved to: "+filtNovelFile+"_reciprocalBlast.txt\n")

        blast_db_exe = r"makeblastdb.exe"
        blast_file = filtNovelFile+"_Protein.fasta"
        cline1 = blast_db_exe+" -in "+blast_file+" -dbtype prot"
        return_code1 = subprocess.call(str(cline1), shell=(sys.platform!="win32"))
        
        blast_exe = r"blastp.exe"
        blast_db=filtNovelFile+"_Protein.fasta" 
        blast_query=filtRefFile+"_Protein.fasta" 
        cline2 = NcbiblastxCommandline(cmd=blast_exe, query=blast_query, db=blast_db, evalue=0.00001, outfmt=10, out=filtRefFile+"_reciprocalBlast.txt")
        return_code2 = subprocess.call(str(cline2), shell=(sys.platform!="win32"))
        self.logger.AppendText("Query: "+filtRefFile+"\n"+"Database: "+filtNovelFile+"\n")
        self.logger.AppendText("Reciprocal BLAST result saved to: "+filtRefFile+"_reciprocalBlast.txt\n")

        file1=open(filtNovelFile+"_reciprocalBlast.txt", "r")
        file2=open(filtRefFile+"_reciprocalBlast.txt", "r")
        resultfile=open(filtNovelFile+"_orthologs.txt", "w")

        evalue = 0.000001
        perID = 60
        alignlenbp = 33

        myDict1={}
        mylist1=[]

        for line in file1:
            line=line.strip()
            l=line.split(",")
            if float(l[-2]) <= evalue and float(l[3]) >= alignlenbp and float(l[2])>= perID:
                if l[1] not in mylist1:
                    myDict1.setdefault(l[0],l[1].split("|")[-1])
                    mylist1.append(l[1])
        
        

        myDict2={}
        mylist2=[]
        for line in file2:
            line=line.strip()
            l=line.split(",")
            if float(l[-2]) <= evalue and float(l[3]) >= alignlenbp and float(l[2])>= perID:
                if l[1] not in mylist2:
                    myList=myDict2.setdefault(l[0],l[1].split("|")[-1])
                    mylist2.append(l[1])
                



        revDict2={}
        for key, val in myDict2.items():
            revDict2[val]=key



        self.reciDict={}
        for KEY,value in myDict1.items():
            if KEY in revDict2.keys():
                if revDict2[KEY]==value:
                    self.reciDict.setdefault(KEY,value)

        file1.close()
        file2.close()
        self.logger.AppendText("Orthologs prediction completed\n")
        self.logger.AppendText("No. of best hit sequences from file1: "+str(len(myDict1.keys()))+"\n")
        self.logger.AppendText("No. of best hit sequences from file2: "+str(len(myDict2.keys()))+"\n")
        self.logger.AppendText("No. of orthologs: "+str(len(self.reciDict.keys()))+"\n")

        orthoNovelFasta=open(filtNovelFile+"_orthologs.fasta", "w")
        orthoRefFasta=open(filtRefFile+"_orthologs.fasta", "w")
        filtRefFasta=SeqIO.index(filtRefFile,"fasta")
        filtNovelFasta=SeqIO.index(filtNovelFile,"fasta")

        for key,val in self.reciDict.items():
            resultfile.write(key+"\t"+val+"\n")
            orthoRefFasta.write(filtRefFasta.get_raw(val))
            orthoNovelFasta.write(filtNovelFasta.get_raw(key))
            
        resultfile.close()
        orthoNovelFasta.close()

        self.logger.AppendText("Orthologous gene list written to: "+filtNovelFile+"_orthologs.txt\n")
        self.logger.AppendText("Orthologous refrence species genes are written to: "+filtRefFile+"_orthologs.fasta\n") 
        self.logger.AppendText("Orthologous novel species genes are written to: "+filtNovelFile+"_orthologs.fasta\n")      
        self.logger.AppendText("Finish Time:  "+str(time.asctime())+"\n")
        self.logger.AppendText("Time elapsed:  "+str(time.time() - start_time)+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Orthlogous gene selection completed\nOrthlog fasta file saved to: "+filtNovelFile+"_orthologs.fasta")

      


#---------FOR SPIDEY--------------------------------------------------------

        
    def ExonPredict(self, event):

        #count Sequences for genomic file
        genomicFile=SeqIO.parse(self.genomicButton.GetValue(), "fasta")
        i=0
        for record in genomicFile:
            i=i+1
            
        
        self.logger.AppendText("Reference genomic file:  "+self.genomicButton.GetValue()+"\nTotal Number of Sequences: "+str(i)+"\n")

        #count Sequences for reference file
        refFile=SeqIO.parse(self.refButton.GetValue(), "fasta")
        j=0
        for record in refFile:
            j=j+1
        self.logger.AppendText("Reference cDNA file:  "+self.refButton.GetValue()+"\nTotal Number of Sequences: "+str(j)+"\n")
        self.logger.AppendText("BLAST started...\n")
        
        #---------FOR FORMAT DATABASE----
        start_time = time.time()
        self.logger.AppendText("Start Time:  "+str(time.asctime())+"\n")
        blast_db_exe = r"makeblastdb.exe"
        blast_file = self.genomicButton.GetValue()
        cline1 = blast_db_exe+" -in "+blast_file+" -dbtype nucl"
        return_code1 = subprocess.call(str(cline1), shell=(sys.platform!="win32"))
        self.logger.AppendText("Database making completed\nTime elapsed:  "+str(time.time() - start_time)+"  seconds\n")

        #---------FOR BLAST SEARCH------------
        start_time = time.time()
        blast_exe = r"blastn.exe"
        blast_db=self.genomicButton.GetValue()
        blast_query=self.refButton.GetValue()
        cline2 = NcbiblastxCommandline(cmd=blast_exe, query=blast_query, db=blast_db, evalue=0.001, outfmt=6, out=self.refButton.GetValue()+"_BLAST_output_table.txt")
        return_code2 = subprocess.call(str(cline2), shell=(sys.platform!="win32"))
        self.logger.AppendText("BLAST completed\nBLAST result saved to: "+self.refButton.GetValue()+"_BLAST_output_table.txt\n")
        
        
        def length(mRNAlen):
            result=mRNAlen.split("-")
            return str(int(result[1])-int(result[0])+1)

        start_time = time.time()
        myList=[]

        blastTableFile=open(self.refButton.GetValue()+"_BLAST_output_table.txt", "r")


        spi=r"Spidey.exe"

        resultFile=open(self.refButton.GetValue()+"_ExonPredict_table.txt","w")
        exonFile=open(self.refButton.GetValue()+"_ExonSequences.fasta","w")
   
  
        genomic=SeqIO.index(self.genomicButton.GetValue(), "fasta")
        cDNA=SeqIO.index(self.refButton.GetValue(), "fasta")
        myList=[]
        box=wx.TextEntryDialog(None, "Enter percent identity to filter BLAST result", "Percent Identity", "95")
        if box.ShowModal()==wx.ID_OK:
            answer=box.GetValue()
        for line in blastTableFile:
            line=line.strip()
            l=line.split("\t")
            if float(l[2])>float(answer):
                if l[0] not in myList:    
                    cDNA_File=open("cDNA.fas", "w")
                    genomicFile=open("genomic.fas", "w")
                    cDNA_File.write(cDNA.get_raw(l[0]))
                    genomicFile.write(genomic.get_raw(l[1]))

                    cDNA_File.close()
                    genomicFile.close()
                    command=spi+" -i genomic.fas -m cDNA.fas -p 1 -o spideytest.txt"
                    return_code = subprocess.call(command, shell=(sys.platform!="win32"))

                    spidey_file=open("spideytest.txt", "r")
                    line1=""   
                    for line in spidey_file:
                        line1=line1+line
                    new=line1.split("\n")
                    i=1
                    for cur_new in new[4:]:
                        cur_new=new[4+i].split(" ")
                        if cur_new[0]!="Number" and cur_new[0]!="":
                            resultFile.write(l[0]+"*"+str(i)+"\t"+l[1]+"\t"+str(i)+"\t"+cur_new[2]+"\t"+cur_new[5]+"\t"+length(cur_new[5])+"\t"+cur_new[9]+"\n")
                            start,end=cur_new[5].split("-")
                            exonFile.write(">"+l[0]+"*"+str(i)+" "+"Exon: "+str(i)+" Length: "+length(cur_new[5])+"\n"+str(cDNA[l[0]].seq[int(start)-1:int(end)])+"\n")
                            i=i+1
                    spidey_file.close()
                    myList.append(l[0])

            
        
        resultFile.close()
        exonFile.close()
                    
        self.logger.AppendText("Exon prediction completed\n")
        self.logger.AppendText("Exon table saved to: "+self.refButton.GetValue()+"_ExonPredict_table.txt\n")
        self.logger.AppendText("Exon sequences saved to: "+self.refButton.GetValue()+"_ExonSequences.fasta\n")
        endtime=str(time.time() - start_time)
        self.logger.AppendText("Time elapsed:  "+endtime+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Exon prediction completed\nTime elapsed:  "+endtime+"  seconds")
        
    def SpideyTable(self, event):
        fileName=self.refButton.GetValue()
        os.popen(fileName+"_ExonPredict_table.txt")

    def ExonFasta(self, event):
        fileName=self.refButton.GetValue()
        os.popen(fileName+"_ExonSequences.fasta")



#-------------FOR NEW SPECIES-----------------------------------------------------

    def NovelExonPredict (self, event):
        start_time=time.time()
        self.logger.AppendText("Conserved Exon Prediction in Novel Species has been started...\n")
        self.logger.AppendText("Start Time:  "+str(time.asctime())+"\n")

        blast_db_exe = r"makeblastdb.exe"
        blast_file = self.novelButton.GetValue()
        cline1 = blast_db_exe+" -in "+blast_file+" -dbtype nucl"
        return_code1 = subprocess.call(str(cline1), shell=(sys.platform!="win32"))
        
        blast_exe = r"tblastx.exe"
        blast_db=self.novelButton.GetValue()
        blast_query=self.refButton.GetValue()+"_ExonSequences.fasta"
        cline2 = NcbiblastxCommandline(cmd=blast_exe, query=blast_query, db=blast_db, evalue=0.00001, outfmt=6, out=self.novelButton.GetValue()+"_tBlastXtable.txt")
        return_code2 = subprocess.call(str(cline2), shell=(sys.platform!="win32"))
        self.logger.AppendText("Query: "+self.refButton.GetValue()+"_ExonSequences.fasta"+"\n"+"Database: "+self.novelButton.GetValue()+"\n")
        self.logger.AppendText("tblastx result saved to: "+self.novelButton.GetValue()+"_tBlastXtable.txt"+"\n")
        

        blastXorthoFile=open(self.novelButton.GetValue()+"_tBlastXtable.txt", "r")                 
        NovelcDNAfile=SeqIO.index(self.novelButton.GetValue(), "fasta")                 
        refExonfile=SeqIO.index(self.refButton.GetValue()+"_ExonSequences.fasta", "fasta")               
        NovelExonSeq=open(self.novelButton.GetValue()+"_OrthoGeneExons.fasta", "w")
        NovelExonTable=open(self.novelButton.GetValue()+"_OrthoExonTable.txt", "w")

        refExonTable=open(self.refButton.GetValue()+"_ExonPredict_table.txt", "r")
        refExonDict={}
        for line in refExonTable:
            line=line.strip()
            l=line.split("\t")
            refExonDict.setdefault(l[0],l[4]+"\t"+l[5])
        refExonTable.close()



        reciOrthoTable=open(self.novelButton.GetValue().replace("_orthologs.fasta","")+"_orthologs.txt", "r")
        myreciDict={}
        for line in reciOrthoTable:
            line=line.strip()
            l=line.split("\t")
            myreciDict.setdefault(l[0],l[1])
        reciOrthoTable.close()

 
        NovelExonTable.write("Reference_ID\tExon_Number\tcDNA_coordinate\tLength\tNovel_ID\tExon_Number\tcDNA_coordinate\tLength\tIdentity\n")

        myList=[]
        for line in blastXorthoFile:
            line=line.strip()
            line=line.split("\t")
            toreplace=line[0].split("*")[-1]
            if float(line[-2])<0.00001 and myreciDict[line[1]]==line[0].replace("*"+toreplace,""): 
                if line[0] not in myList:
                    if int(line[6])<10 and len(str(refExonfile[line[0]].seq))-int(line[7])<10:
                        start,end=int(line[-4])-int(line[6]),int(line[-3])+len(str(refExonfile[line[0]].seq))-int(line[7])
                        length=str(end-start)
                        exN=line[0].split("*")[-1]
                        NovelExonSeq.write(">"+line[1]+"_Exon-"+exN+" Length:"+length+"\n"+str(NovelcDNAfile[line[1]].seq[start:end])+"\n")     
                        NovelExonTable.write(line[0]+"\t"+exN+"\t"+refExonDict[line[0]]+"\t"+line[1]+"\t"+exN+"\t"+str(start+1)+"-"+str(end)+"\t"+length+"\t"+line[2]+"\n")                                            
                
                    if int(line[6])>9 and len(str(refExonfile[line[0]].seq))-int(line[7])<10:     
                        start,end=int(line[-4]),int(line[-3])+len(str(refExonfile[line[0]].seq))-int(line[7])                    
                        addNstart=(int(line[-4])-int(line[6]))*"N"       
                        exN=line[0].split("*")[-1]
                        NovelExonSeq.write(">"+line[1]+"_Exon-"+exN+" Length:"+"unk"+"\n"+addNstart+str(NovelcDNAfile[line[1]].seq[start:end])+"\n")
                        NovelExonTable.write(line[0]+"\t"+exN+"\t"+refExonDict[line[0]]+"\t"+line[1]+"\t"+exN+"\t"+"unk"+"-"+str(end)+"\t"+"unk"+"\t"+line[2]+"\n")                      

                    if int(line[6])<10 and len(str(refExonfile[line[0]].seq))-int(line[7])>9:
                        start,end=int(line[-4])-int(line[6]),int(line[-3])
                        addNend=(len(str(refExonfile[line[0]].seq))-int(line[7]))*"N"
                        exN=line[0].split("*")[-1]
                        NovelExonSeq.write(">"+line[1]+"_Exon-"+exN+" Length:"+"unk"+"\n"+str(NovelcDNAfile[line[1]].seq[start:end])+addNend+"\n")
                        NovelExonTable.write(line[0]+"\t"+exN+"\t"+refExonDict[line[0]]+"\t"+line[1]+"\t"+exN+"\t"+str(start+1)+"-"+"unk"+"\t"+"unk"+"\t"+line[2]+"\n")

                    if int(line[6])>9 and len(str(refExonfile[line[0]].seq))-int(line[7])>9:
                        start,end=int(line[-4]),int(line[-3])
                        addNstart=(int(line[-4])-int(line[6]))*"N"
                        addNend=(len(str(refExonfile[line[0]].seq))-int(line[7]))*"N"
                        exN=line[0].split("*")[-1]
                        NovelExonSeq.write(">"+line[1]+"_Exon-"+exN+" Length:"+"unk"+"\n"+addNstart+str(NovelcDNAfile[line[1]].seq[start:end])+addNend+"\n")
                        NovelExonTable.write(line[0]+"\t"+exN+"\t"+refExonDict[line[0]]+"\t"+line[1]+"\t"+exN+"\t"+"unk"+"-"+"unk"+"\t"+"unk"+"\t"+line[2]+"\n")
    
                    myList.append(line[0])



        blastXorthoFile.close()
        NovelExonSeq.close()
        NovelExonTable.close()
                                             
        self.logger.AppendText("Conserved Exon Prediction in Novel Species completed\n")
        self.logger.AppendText("Novel Species Exon table saved to: "+self.novelButton.GetValue()+"_OrthoExonTable.txt\n")
        self.logger.AppendText("Novel Species Exon sequences saved to: "+self.novelButton.GetValue()+"_OrthoGeneExons.fasta\n")
        endtime=str(time.time() - start_time)
        self.logger.AppendText("Time elapsed:  "+endtime+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Conserved Exon Prediction in Novel Species completed\nTime elapsed:  "+endtime+"  seconds")
        
    def NovelTable(self, event):
        os.popen(self.novelButton.GetValue()+"_OrthoExonTable.txt")

    def NovelExon(self, event):
        os.popen(self.novelButton.GetValue()+"_OrthoGeneExons.fasta")


#---------------------------------------------------------------------------

if __name__ == '__main__':
    app = wx.PySimpleApp()
    frame = MyFrame(parent=None, id=-1)
    frame.Show(True)
    app.MainLoop()


