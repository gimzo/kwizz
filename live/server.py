#!/usr/bin/env python2

#konfiguracija na slijedecoj liniji:
URL="http://localhost/kwizz"
#kraj konfiguracije


import sys

from twisted.python import log
from twisted.internet import reactor
import json
from autobahn.websocket import WebSocketServerProtocol, WebSocketServerFactory
import urllib2

kwizz=None

#ovo je fancy naziv za "player"
class KwizzLiveProtocol(WebSocketServerProtocol):

   def __init__(self):
      self.name=None
      self.state=None
      global kwizz
      self.comm=kwizz
      
   def onConnect(self, request):
      print("Client connecting: {0}".format(request.peer))
      self.status=0

   def onOpen(self):
      print("connection open.")

   def onMessage(self, payload, isBinary):
      #print "message received"
      if isBinary:
         return
      else:
         msg=payload.decode('utf8')
         #print msg
         #print self.status
         if (self.status==0):
            #print "state je 0"
            if (msg[0]=="U"):
               print "player detected"
               self.name=msg[1:]
               self.comm.getPlayer(self)
               self.status=1
         elif (self.status==1):
            print "odgovor primljen"
            if (msg[0]=="T"):
               self.comm.odgovor(self,True)
            if (msg[0]=="N"):
               self.comm.odgovor(self,False)

   def sendQuestion(self,question):
      self.sendMessage(question)
   def sendStuff (self,data):
      self.sendMessage(json.dumps(data))

   def onClose(self, wasClean, code, reason):
      self.comm.kraj(self)
      print("connection closed: {0}".format(reason))


#runda
class Game():
   
   def __init__(self,p1,p2):
      self.p1=p1
      self.p2=p2
      self.p1score=0
      self.p2score=0
      self.running=False
      p1.comm=self
      p2.comm=self
      self.p1s=0 # 0 - start 1 - ceka odgovor 2 - odgovoreno
      self.p2s=0
      print p1.name, p2.name,"su u igri"
      p1.sendStuff({"tip":"opponent","ime":p2.name})
      p2.sendStuff({"tip":"opponent","ime":p1.name})
      self.broj_pitanja=10
      self.pitanje=1
      #postavi prvo pitanje
      self.running=True
      self.postaviPitanje()

   def postaviPitanje(self):
      if self.pitanje==self.broj_pitanja+1:
         self.kraj()
      else:
         infoPitanje={"tip":"broj","sad":self.pitanje, "total":self.broj_pitanja}
         self.p1.sendStuff(infoPitanje)
         self.p2.sendStuff(infoPitanje)
         self.odgovoreno=0
         pitanje=urllib2.urlopen(URL+"/resources/library/get_question.php").read() #pokupi randomno pitanje
         self.p1.sendQuestion(pitanje)
         self.p2.sendQuestion(pitanje)
         self.p1s=1
         self.p2s=1
         self.pitanje=self.pitanje+1
         print "postavljeno pitanje", self.pitanje

   def kraj(self, broken=None):
      if not self.running: return
      self.running=False
      report={"tip":"kraj","p1":self.p1.name,"p2":self.p2.name,"s1":self.p1score,"s2":self.p2score}
      if broken:
         report['broken']=broken.name
      self.p1.sendStuff(report)
      self.p2.sendStuff(report)


   def odgovor(self,tko,tocno):
      if not self.running : return
      self.odgovoreno=self.odgovoreno+1
      print "odgovor", tko.name, tocno
      if (tko==self.p1 and self.p1s==1):
         if tocno: self.p1score=self.p1score+1
         self.p2.sendStuff({"tip":"odgovor","ime":self.p1.name, "tocno":tocno})
         self.p1s=2
      if (tko==self.p2 and self.p2s==1):
         if tocno: self.p2score=self.p2score+1
         self.p1.sendStuff({"tip":"odgovor","ime":self.p2.name, "tocno":tocno})
         self.p2s=2
      if (self.p1s==2 and self.p2s==2):
         self.postaviPitanje()

#lobby
class KwizzLive():

   def __init__(self):
      global kwizz
      kwizz=self
      self.players=[]
      self.games=[]
      factory = WebSocketServerFactory("ws://localhost:9000", debug = False)
      factory.protocol = KwizzLiveProtocol
      reactor.listenTCP(9000, factory)
      reactor.run()

   def getPlayer(self,player):
      self.players.append(player)
      print "dodan je player"
      self.findGames()

   def findGames(self):
      print "trazenje parova"
      par=self.getIdlePlayers()
      if par:
         self.games.append(Game(par[0],par[1]))

   def getIdlePlayers(self):
      if len(self.players)>1:
         return [self.players.pop(), self.players.pop()]
      return False

   def kraj(self, broken=None):
      pass


if __name__ == '__main__':
   log.startLogging(sys.stdout)
   KwizzLive()
