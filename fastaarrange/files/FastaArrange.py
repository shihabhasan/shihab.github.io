import  wx
import  wx.lib.filebrowsebutton as filebrowse
from Bio.Blast.Applications import NcbiblastxCommandline
import sys
import os
import subprocess
from Bio import SeqIO
import time


class MyFrame(wx.Frame):
    def __init__(self, parent, id):
        wx.Frame.__init__(self, parent, id, 'FastaArrange', size=(500, 500))
        self.panel = wx.Panel(self, -1)

#---------------------------------------------------------------------------

        # Part-1: Create menubar

        status=self.CreateStatusBar()
        menubar=wx.MenuBar()
        first=wx.Menu()
        second=wx.Menu()
        third=wx.Menu()

        openMenu=first.Append(wx.NewId(), "Open", "Open file")
        self.Bind(wx.EVT_MENU, self.openFile, openMenu)
        
        SaveLogMenu=first.Append(wx.NewId(), "Save log...", "Save the log in a text file")
        self.Bind(wx.EVT_MENU, self.SaveLog, SaveLogMenu)
        
        quitMenu=first.Append(wx.NewId(), "Exit", "Close the program")
        self.Bind(wx.EVT_MENU, self.Quit, quitMenu)



        fastaUpperMenu=second.Append(wx.NewId(), "lowercase to UPPERCASE", "Converts Lowercase sequence fasta file to Uppercase sequence Fasta file")
        self.Bind(wx.EVT_MENU, self.lower2upper, fastaUpperMenu)

        fastaLowerMenu=second.Append(wx.NewId(), "UPPERCASE to lowercase", "Converts Uppercase  sequence fasta file to  Lowercase sequence Fasta file")
        self.Bind(wx.EVT_MENU, self.upper2lower, fastaLowerMenu) 

        gbkMenu=second.Append(wx.NewId(), "GenBank to Fasta", "Converts Genebank file to Fasta file")
        self.Bind(wx.EVT_MENU, self.gbk2fasta, gbkMenu)

        fastqMenu=second.Append(wx.NewId(), "FASTQ to FASTA", "Converts Fastq file to Fasta file")
        self.Bind(wx.EVT_MENU, self.fastq2fasta, fastqMenu)

        emblMenu=second.Append(wx.NewId(), "EMBL to FASTA", "Converts EMBL file to Fasta file")
        self.Bind(wx.EVT_MENU, self.embl2fasta, emblMenu)

        aceMenu=second.Append(wx.NewId(), "ACE to FASTA", "Converts ACE file to Fasta file")
        self.Bind(wx.EVT_MENU, self.ace2fasta, aceMenu)

        clustalMenu=second.Append(wx.NewId(), "CLUSTAL to FASTA", "Converts CLUSTAL file to Fasta file")
        self.Bind(wx.EVT_MENU, self.clustal2fasta, clustalMenu)

##        igMenu=second.Append(wx.NewId(), "IG to FASTA", "Converts IG (IntelliGenetics) file to Fasta file")
##        self.Bind(wx.EVT_MENU, self.ig2fasta, igMenu)
##
##        imgtMenu=second.Append(wx.NewId(), "IMGT to FASTA", "Converts IMGT file to Fasta file")
##        self.Bind(wx.EVT_MENU, self.imgt2fasta, imgtMenu)

        nexusMenu=second.Append(wx.NewId(), "NEXUS to FASTA", "Converts NEXUS file to Fasta file")
        self.Bind(wx.EVT_MENU, self.nexus2fasta, nexusMenu)

##        phdMenu=second.Append(wx.NewId(), "PHD to FASTA", "Converts PHD file to Fasta file (PHD files are output from PHRED)")
##        self.Bind(wx.EVT_MENU, self.phd2fasta, phdMenu)

        phylipMenu=second.Append(wx.NewId(), "PHYLIP to FASTA", "Converts PHYLIP file to Fasta file")
        self.Bind(wx.EVT_MENU, self.phylip2fasta, phylipMenu)

        phylip2Menu=second.Append(wx.NewId(), "FASTA to PHYLIP", "Converts aligned Fasta file to PHYLIP file")
        self.Bind(wx.EVT_MENU, self.fasta2phylip, phylip2Menu)

        pirMenu=second.Append(wx.NewId(), "PIR to FASTA", "Converts PIR file to Fasta file")
        self.Bind(wx.EVT_MENU, self.pir2fasta, pirMenu)

        stockholmMenu=second.Append(wx.NewId(), "STOCKHOLM to FASTA", "Converts STOCKHOLM file to Fasta file")
        self.Bind(wx.EVT_MENU, self.stockholm2fasta, stockholmMenu)

        swissMenu=second.Append(wx.NewId(), "SWISS to FASTA", "Converts SWISS file to Fasta file")
        self.Bind(wx.EVT_MENU, self.swiss2fasta, swissMenu)

        tabMenu=second.Append(wx.NewId(), "TAB to FASTA", "Converts TAB file to Fasta file (Simple two column tab separated sequence file)")
        self.Bind(wx.EVT_MENU, self.tab2fasta, tabMenu)

##        qualMenu=second.Append(wx.NewId(), "QUAL to FASTA", "Converts QUAL file to Fasta file")
##        self.Bind(wx.EVT_MENU, self.qual2fasta, qualMenu)

##        uniprotxmlMenu=second.Append(wx.NewId(), "UNIPROT-XML to FASTA", "Converts UNIPROT-XML file to Fasta file")
##        self.Bind(wx.EVT_MENU, self.uniprotxml2fasta, uniprotxmlMenu)

#        megMenu=second.Append(wx.NewId(), "Fast to Meg", "Converts Fasta file to Meg file for MEGA")

##        menuitem = wx.Menu()\
##        NuclDBmenu=menuitem.Append(-1, 'Nucleotide', "Makes Nucleotide database")
##        ProtDBmenu=menuitem.Append(-1, 'Protein', "Makes Protein database")
##        second.AppendMenu(-1, 'Make Database', menuitem)

        SplitFastaMenu=third.Append(wx.NewId(), "Split Fasta File", "Split Fasta File")
        self.Bind(wx.EVT_MENU, self.SplitFasta, SplitFastaMenu)
        
        CountFastaMenu=third.Append(wx.NewId(), "Count Sequences Number", "Get total number of sequences in the Fasta file")
        self.Bind(wx.EVT_MENU, self.CountSeq, CountFastaMenu)
        
        IDFastaMenu=third.Append(wx.NewId(), "Get Sequence by ID", "Get the sequence by ID in the Fasta file")
        self.Bind(wx.EVT_MENU, self.ById, IDFastaMenu)
        
        NumFastaMenu=third.Append(wx.NewId(), "Get Sequence by Number", "Get the sequence by Number in the Fasta file")
        self.Bind(wx.EVT_MENU, self.ByNum, NumFastaMenu)

        LenFastaMenu=third.Append(wx.NewId(), "Get Sequences Length List", "Get the sequences length in the Fasta file")
        self.Bind(wx.EVT_MENU, self.LenList, LenFastaMenu)
        
        DNA2ProtMenu=third.Append(wx.NewId(), "Nucleotide to Protein", "Converts Nucleotide Fasta file to Protein Fasta file")
        self.Bind(wx.EVT_MENU, self.DNA2Prot, DNA2ProtMenu)

        ExcludeSubsetMenu=third.Append(wx.NewId(), "Exclude subset sequences", "Exclude subset of sequences from the Fasta file")
        self.Bind(wx.EVT_MENU, self.ExcludeSubset, ExcludeSubsetMenu)


        menubar.Append(first, "File")
        menubar.Append(second, "Convert Format")
        menubar.Append(third, "Deals with Fasta")
        self.SetMenuBar(menubar)

        self.logger= wx.TextCtrl(self.panel, -1, pos=(15,15), size=(450,320),style=wx.TE_MULTILINE | wx.TE_READONLY)

        wx.StaticText(self.panel, -1, 'Developed By:',(15,350),(-1, -1))
        wx.StaticText(self.panel, -1, 'Shihab Hasan',(15,365),(-1, -1))
        wx.StaticText(self.panel, -1, 'University of Turku, Finland',(15,380),(-1, -1))
        wx.StaticText(self.panel, -1, 'http://shihabhasan.com',(15,395),(-1, -1))


    #---------------------FILE----------------------------------------------------------

    def openFile(self, event):
        dlg = wx.FileDialog(self, message="Choose file", defaultDir=os.getcwd(), defaultFile="", style=wx.OPEN | wx.CHANGE_DIR)
        if dlg.ShowModal() == wx.ID_OK:
            self.globalFile = dlg.GetPath()
        dlg.Destroy()



    def SaveLog(self, event):
        inFile = self.globalFile
        self.logger.SaveFile(inFile+"_FastaArrange_log.txt")
        self.logger.AppendText("FastaArrange log file saved to "+inFile+"_FastaArrange_log.txt\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("FastaArrange log file saved to "+inFile+"_FastaArrange_log.txt")
        
        

    def Quit(self, event):
        self.Close()

    #-------------------CONVERTERS-----------------------------------------------

    def lower2upper(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        outfile=open(inFile+"_UPPERCASE.fasta", "w")
        records=SeqIO.parse(inFile, "fasta")
        for record in records:
            outfile.write(">"+record.description+"\n"+str(record.seq.upper())+"\n")
        outfile.close()
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("Lowercase sequence to Uppercase sequence Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+"_UPPERCASE.fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Lowercase sequence to Uppercase sequence Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

    def upper2lower(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        outfile=open(inFile+"_lowercase.fasta", "w")
        records=SeqIO.parse(inFile, "fasta")
        for record in records:
            outfile.write(">"+record.description+"\n"+str(record.seq.lower())+"\n")
        outfile.close()
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("Uppercase sequence to Lowercase sequence Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+"_lowercase.fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Uppercase sequence to Lowercase sequence Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


    def gbk2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "genbank", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("GenBank to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("GenBank to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


    def fastq2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "fastq", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("Fastq to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Fastq to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


    def embl2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "embl", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("EMBL to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("EMBL to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")
        

    def ace2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "ace", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("ACE to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("ACE to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


    def clustal2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "clustal", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("CLUSTAL to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("CLUSTAL to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


##    def ig2fasta(self, event):
##        inFile = self.globalFile
##        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
##        start_time = time.time()
##        
##        SeqIO.convert(inFile, "ig", inFile+".fasta", "fasta")
##   
##        end_time=str(time.time() - start_time) 
##        self.logger.AppendText("IG to Fasta making completed\n")
##        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
##        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
##        wx.MessageBox("IG to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")
##
##
##    def imgt2fasta(self, event):
##        inFile = self.globalFile
##        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
##        start_time = time.time()
##        
##        SeqIO.convert(inFile, "imgt", inFile+".fasta", "fasta")
##   
##        end_time=str(time.time() - start_time) 
##        self.logger.AppendText("IMGT to Fasta making completed\n")
##        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
##        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
##        wx.MessageBox("IMGT to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


    def nexus2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "nexus", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("NEXUS to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("NEXUS to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


##    def phd2fasta(self, event):
##        inFile = self.globalFile
##        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
##        start_time = time.time()
##        
##        SeqIO.convert(inFile, "phd", inFile+".fasta", "fasta")
##   
##        end_time=str(time.time() - start_time) 
##        self.logger.AppendText("PHD to Fasta making completed\n")
##        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
##        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
##        wx.MessageBox("PHD to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

        
    def phylip2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "phylip", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("PHYLIP to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("PHYLIP to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

    def fasta2phylip(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "fasta", inFile+".phylip", "phylip")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("Fasta to PHYLIP making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".phylip"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Fasta to PHYLIP making completed\nTime elapsed:  "+end_time+"  seconds")


    def pir2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "pir", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("PIR to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("PIR to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")
        
                
    def stockholm2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "stockholm", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("STOCKHOLM to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("STOCKHOLM to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

                
    def swiss2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "swiss", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("SWISS to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("SWISS to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

            
    def tab2fasta(self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        
        SeqIO.convert(inFile, "tab", inFile+".fasta", "fasta")
   
        end_time=str(time.time() - start_time) 
        self.logger.AppendText("TAB to Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("TAB to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

        
##    def qual2fasta(self, event):
##        inFile = self.globalFile
##        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
##        start_time = time.time()
##        
##        SeqIO.convert(inFile, "qual", inFile+".fasta", "fasta")
##   
##        end_time=str(time.time() - start_time) 
##        self.logger.AppendText("QUAL to Fasta making completed\n")
##        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
##        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
##        wx.MessageBox("QUAL to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")

                
##    def uniprotxml2fasta(self, event):
##        inFile = self.globalFile
##        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
##        start_time = time.time()
##        
##        SeqIO.convert(inFile, "uniprot-xml", inFile+".fasta", "fasta")
##   
##        end_time=str(time.time() - start_time) 
##        self.logger.AppendText("UNIPROT-XML to Fasta making completed\n")
##        self.logger.AppendText("Output File:  "+inFile+".fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
##        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
##        wx.MessageBox("UNIPROT-XML to Fasta making completed\nTime elapsed:  "+end_time+"  seconds")
##
        
    #-----------------------------------------------------------------------------------
        

    def SplitFasta(self, event):
        def batch_iterator(iterator, batch_size) :
            entry = True 
            while entry :
                batch = []
                while len(batch) < batch_size :
                    try :
                        entry = iterator.next()
                    except StopIteration :
                        entry = None
                    if entry is None :
                        break
                    batch.append(entry)
                if batch :
                    yield batch

        #take batch size
        box=wx.TextEntryDialog(None, "Enter Batch Size", "Batch Size", "100")

        if box.ShowModal() == wx.ID_OK:
            BatchSize = box.GetValue()

        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()

        record_iter = SeqIO.parse(inFile,"fasta")

        for i, batch in enumerate(batch_iterator(record_iter, int(BatchSize))) : #give batch size
            filename = inFile+"_part_%i.fasta" % (i+1)
            outFile = open(filename, "w")
            count = SeqIO.write(batch, outFile, "fasta")
            outFile.close()
            self.logger.AppendText("Wrote %i records to  %s" % (count, filename)+"    "+str(time.asctime())+"\n")
   
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Fasta file splitting completed\n")
        self.logger.AppendText("Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Fasta file splitting completed\nTime elapsed:  "+end_time+"  seconds")
     

    def CountSeq (self, event):
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
       
        fastaFile=SeqIO.parse(inFile, "fasta")

        i=0
        for record in fastaFile:
            i=i+1
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Counting completed\nTotal Number of Sequences  :"+str(i)+"\n")
        self.logger.AppendText("Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Counting completed\nTotal Number of Sequences  :"+str(i)+"\nTime elapsed:  "+end_time+"  seconds")


    def ById (self, event):
        box=wx.TextEntryDialog(None, "Enter Sequence ID\nFor Multiple IDs use comma (,) as separator", "Sequence ID", "ID")

        if box.ShowModal() == wx.ID_OK:
            IDlist = box.GetValue()
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()

        FastaFile=SeqIO.index(inFile, "fasta")

        outFile=open(inFile+"_by_ID.fasta", "w")
        
        IDlist=IDlist.replace(" ","")
        IDs=IDlist.split(",")
        for ID in IDs:
            if ID in FastaFile:
                outFile.write(FastaFile.get_raw(ID))
                self.logger.AppendText("Wrote "+inFile+"_by_ID.fasta"+"    "+str(time.asctime())+"\n")
            if ID not in FastaFile:
                self.logger.AppendText(ID+" not present in the Fasta file\n")
        outFile.close()
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Fasta file making by ID is completed\n")
        self.logger.AppendText("Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Fasta file making by ID is completed\nTime elapsed:  "+end_time+"  seconds")



    def ByNum (self, event):
        box=wx.TextEntryDialog(None, "Enter Sequence Number\nFor Multiple Sequence Numbers use comma (,) as separator", "Sequence Number", "50")

        if box.ShowModal() == wx.ID_OK:
            Numbers = box.GetValue()
        inFile = self.globalFile
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()

        FastaFile=SeqIO.parse(inFile, "fasta")

        outFile=open(inFile+"_by_Number.fasta", "w")
        
        Numbers=Numbers.replace(" ","")
        Numbs=Numbers.split(",")
        NumList=[]
        for n in Numbs:
            NumList.append(int(n))
        NumList.sort()
        
        i=1
        for record in FastaFile:
            if i in NumList:
                outFile.write(">"+record.description+"\n"+str(record.seq)+"\n")
            i=i+1
        outFile.close()
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Fasta file making by Number is completed\n")
        self.logger.AppendText("Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Fasta file making by Number is completed\nTime elapsed:  "+end_time+"  seconds")



    def LenList (self, event):
        inFile = self.globalFile
        outFile=open(inFile+"_Length_List.txt", "w")
        outFile.write("ID\tLength\n")
        FastaFile=SeqIO.parse(inFile, "fasta")
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()

        for record in FastaFile:
            outFile.write(record.id+"\t"+str(len(record.seq))+"\n")

        outFile.close()
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Length List making completed\n")
        self.logger.AppendText("Output File:  "+inFile+"_Length_List.txt"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Length List making completed\nTime elapsed:  "+end_time+"  seconds")

     
          

    def DNA2Prot (self, event):
        inFile = self.globalFile
        outFile=open(inFile+"_Protein.fasta", "w")
        DNAfile=SeqIO.parse(inFile, "fasta")
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()

        for record in DNAfile:
            outFile.write(str(">"+record.description+"\n"+record.seq.translate()+"\n"))

        outFile.close()
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Protein Fasta making completed\n")
        self.logger.AppendText("Output File:  "+inFile+"_Protein.fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Protein Fasta making completed\nTime elapsed:  "+end_time+"  seconds")


    def ExcludeSubset (self, event):
        inFile = self.globalFile

        dlg = wx.FileDialog(self, message="Choose file with ID list to be excluded", defaultDir=os.getcwd(), defaultFile="", style=wx.OPEN | wx.CHANGE_DIR)
        if dlg.ShowModal() == wx.ID_OK:
            self.globalFile1 = dlg.GetPath()
        dlg.Destroy()
        idFile = self.globalFile1
        idlistFile=open(idFile, "r")
        idList=[]
        self.logger.AppendText("Input file:  "+inFile+"\n"+"Input ID list file:  "+idFile+"\n"+"Start Time:  "+str(time.asctime())+"\n")
        start_time = time.time()
        for line in idlistFile:
            line=line.strip()
            idList.append(line)
        idlistFile.close()
        outFile=open(inFile+"_excluded_subset.fasta", "w")
        fastaFile=SeqIO.parse(inFile, "fasta")
        
        for record in fastaFile:
            if record.id not in idList:
                outFile.write(str(">"+record.description+"\n"+record.seq+"\n"))

        outFile.close()
        end_time=str(time.time() - start_time)
        self.logger.AppendText("Subset sequences have been excluded\n")
        self.logger.AppendText("Output File:  "+inFile+"_excluded_subset.fasta"+"\n"+"Finish Time:  "+str(time.asctime())+"\nTime elapsed:  "+end_time+"  seconds\n")
        self.logger.AppendText("--------------------------------------------------------------------------------------------------------\n\n")
        wx.MessageBox("Subset sequences have been excluded\nTime elapsed:  "+end_time+"  seconds")
     

    

#---------------------------------------------------------------------------

if __name__ == '__main__':
    app = wx.PySimpleApp()
    frame = MyFrame(parent=None, id=-1)
    frame.Show(True)
    app.MainLoop()


