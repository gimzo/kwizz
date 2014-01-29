import sys

from twisted.python import log
from twisted.internet import reactor
import json
from autobahn.websocket import WebSocketServerProtocol, WebSocketServerFactory
import urllib2

kwizz=None

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
      print("WebSocket connection open.")

   def onMessage(self, payload, isBinary):
      print "message received"
      if isBinary:
         return
      else:
         msg=payload.decode('utf8')
         print msg
         print self.status
         if (self.status==0):
            print "state je 0"
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
      print("WebSocket connection closed: {0}".format(reason))



class Game():
   
   def __init__(self,p1,p2):
      self.p1=p1
      self.p2=p2
      self.p1score=0
      self.p2score=0
      p1.comm=self
      p2.comm=self
      print p1.name, p2.name,"su u igri"
      p1.sendStuff({"tip":"opponent","ime":p2.name})
      p2.sendStuff({"tip":"opponent","ime":p1.name})
      self.broj_pitanja=3
      self.pitanje=1
      #postavi prvo pitanje
      self.postaviPitanje()
      
   def postaviPitanje(self):
      if self.pitanje==self.broj_pitanja+1:
         self.kraj()
      else:
         self.p1.sendStuff({"tip":"broj","sad":self.pitanje, "total":self.broj_pitanja})
         self.p2.sendStuff({"tip":"broj","sad":self.pitanje, "total":self.broj_pitanja})
         self.odgovoreno=0
         pitanje=urllib2.urlopen("http://localhost/kwizz/get_question.php").read()
         self.p1.sendQuestion(pitanje)
         self.p2.sendQuestion(pitanje)
         self.pitanje=self.pitanje+1

   def kraj(self):
      self.p1.sendStuff({"tip":"kraj","p1":self.p1.name,"p2":self.p2.name,"s1":self.p1score,"s2":self.p2score})
      self.p2.sendStuff({"tip":"kraj","p1":self.p1.name,"p2":self.p2.name,"s1":self.p1score,"s2":self.p2score})


   def odgovor(self,tko,tocno):
      self.odgovoreno=self.odgovoreno+1
      print "odgovor", tko.name, tocno
      if (tko==self.p1):
         if tocno: self.p1score=self.p1score+1
         self.p2.sendStuff({"tip":"odgovor","ime":self.p1.name, "tocno":tocno})
      if (tko==self.p2):
         if tocno: self.p2score=self.p2score+1
         self.p1.sendStuff({"tip":"odgovor","ime":self.p2.name, "tocno":tocno})
      if (self.odgovoreno==2):
         self.postaviPitanje()
      

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
      self.players.append([player,False])
      print "dodan je player"
      self.findGames()

   def findGames(self):
      print "trazenje parova"
      par=self.getIdlePlayers()
      if par:
         print "par nadjen"
         par[0][1]=True
         par[1][1]=True
         self.games.append(Game(par[0][0],par[1][0]))

   def getIdlePlayers(self):
      idlePlayers=[]
      for p in self.players:
         if (p[1]==False):
            idlePlayers.append(p)
         if (len(idlePlayers)==2):
            return idlePlayers
      return False


if __name__ == '__main__':
   log.startLogging(sys.stdout)
   KwizzLive()
