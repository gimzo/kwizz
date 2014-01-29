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
            print "state je ok"
            if (msg[0]=="U"):
               print "player detected"
               self.name=msg[1:]
               self.comm.getPlayer(self)

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
      p1.comm=self
      p2.comm=self
      print p1.name, p2.name,"su u igri"
      p1.sendStuff({"tip":"opponent","ime":p2.name})
      p2.sendStuff({"tip":"opponent","ime":p1.name})
      self.broj_pitanja=10
      self.pitanje=1
      #postavi prvo pitanje
      self.postaviPitanje()
      
   def postaviPitanje(self):
      pitanje=urllib2.urlopen("http://localhost/kwizz/get_question.php").read()
      self.p1.sendQuestion(pitanje)
      self.p2.sendQuestion(pitanje)
      self.pitanje=self.pitanje+1
      

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
