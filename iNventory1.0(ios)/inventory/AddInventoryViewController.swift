//
//  AddInventoryViewController.swift
//  inventory
//
//  Created by admin on 1/22/16.
//  Copyright © 2016 admin. All rights reserved.
//

import UIKit


class AddInventoryViewController: UIViewController, UITextViewDelegate, UINavigationControllerDelegate, UIImagePickerControllerDelegate, UIPickerViewDelegate, UIPickerViewDataSource, BarcodeScan {
    @IBOutlet var pickerpanel: UIView!

    @IBOutlet var scrollview: UIScrollView!
    @IBOutlet var photo: UIImageView!
    @IBOutlet var partNumber: UITextField!
    @IBOutlet var serialNumber: UITextField!
    @IBOutlet var txtDescription: UITextView!
    @IBOutlet var txtRemark: UITextView!
    @IBOutlet var txtQuantity: UITextField!
    @IBOutlet var txtLocation: UITextField!
    
    @IBOutlet var pickerdescription: UIPickerView!
    @IBOutlet var pickerlocation: UIPickerView!
    
    @IBOutlet var btnpickerdescription: UIButton!
    
    @IBOutlet var btnpickerlocation: UIButton!
    
    @IBOutlet var activityindicatorcontainer: UIView!
    var serialnumber: String?
    var partnumber: String?
    var strDescription: String?
    var strRemark: String?
    var strQuantity: String?
    var strLoation: String?
    var imageData: NSData?
    
    
    var listlocationdata = [String]()
    var listdescriptiondata = [String]()
    
    
    
    
   
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        
        setinit()
       

        
        setplaceholder()
        
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
     // Get the new view controller using segue.destinationViewController.
     // Pass the selected object to the new view controller.
        
        
        if segue.identifier == "partnumber" {
            if let destinationVC = segue.destination as? BarcodeReaderViewController {
                destinationVC.whichnumber = "partnumber"
                destinationVC.barcodescanresult = self
            }
        }
        else if segue.identifier == "serialnumber" {
            if let destinationVC = segue.destination as? BarcodeReaderViewController {
                destinationVC.whichnumber = "serialnumber"
                destinationVC.barcodescanresult = self
                
            }
        }
    }
    
    func setinit() {
        scrollview.isScrollEnabled = false
        activityindicatorcontainer.isHidden = false
        showActivityIndicatory(uiView: activityindicatorcontainer)
        setpickerdata()
    }
    
    func setpickerdata() {
        
       
       
        //let json = ["email":email, "password":pass]
        
        do {
            //let jsonData = try JSONSerialization.data(withJSONObject: json, options: .prettyPrinted)
            
            let url = StaticData.getlink() + "get_location_description.php"
            
            var request = URLRequest(url: URL(string: url)!)
            
            request.httpMethod = "POST"
            //request.httpBody = jsonData
            //request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")
            
            
            let task = URLSession.shared.dataTask(with: request) { (data: Data?, response: URLResponse?, error: Error?) in
                
                if error != nil
                {
                    print("error=\(error)")
                    return
                }
                
                // You can print out response object
                print("response = \(response)")
                
                //Let's convert response sent from a server side script to a NSDictionary object:
                do {
                    
                    let json = try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as? NSDictionary
                    
                    if let parseJSON = json {
                        
                        // Now we can access value of First Name by its key
                        if let location = parseJSON["location"] as? NSDictionary {
                            if location.count > 0 {
                                self.listlocationdata.append("")
                                for var i in(0..<location.count) {
                                    self.listlocationdata.append(location.value(forKey: "a" + String(i)) as! String)
                                }
                            }
                        }
                        
                        
                        if let description = parseJSON["description"] as? NSDictionary {
                            if description.count > 0 {
                                self.listdescriptiondata.append("")
                                for var i in(0..<description.count) {
                                    self.listdescriptiondata.append(description.value(forKey: "a" + String(i)) as! String)
                                }
                            }
                        }

                       
                        
                        
                        
                    }
                    
                } catch {
                    print("error")
                }
                
                
                self.setpicker()
            }
            task.resume()
            
            
        } catch {
            print("error")
        }
        

        
    }
    
    func setpicker() {
        DispatchQueue.main.async { [unowned self] in
            self.activityindicatorcontainer.isHidden = true
            self.scrollview.isScrollEnabled = true
            
            if self.listdescriptiondata.count > 0 {
                self.btnpickerdescription.isHidden = false
                
            }
            
            if self.listlocationdata.count > 0 {
                self.btnpickerlocation.isHidden = false
                
            }
            
            
        }

    }
    
    func showActivityIndicatory(uiView: UIView) {
        
        let loadingView: UIView = UIView()
        loadingView.frame = CGRect.init(x: 0, y: 0, width: 80, height: 80)
        let screenSize = UIScreen.main.bounds
        let screenWidth = screenSize.width
        let screenHeight = screenSize.height
        loadingView.center = CGPoint.init(x: screenWidth / 2, y: screenHeight / 2)
        loadingView.backgroundColor = UIColor.lightGray.withAlphaComponent(0.7)
        loadingView.clipsToBounds = true
        loadingView.layer.cornerRadius = 10
        
        let actInd: UIActivityIndicatorView = UIActivityIndicatorView()
        actInd.frame = CGRect.init(x:0.0, y:0.0, width:40.0, height:40.0);
        actInd.activityIndicatorViewStyle =
            UIActivityIndicatorViewStyle.whiteLarge
        
        actInd.center = CGPoint.init(x: loadingView.frame.size.width / 2,
                                     y:loadingView.frame.size.height / 2);
        loadingView.addSubview(actInd)
        uiView.addSubview(loadingView)
        
        actInd.startAnimating()
    }

    
    
    
    func selectImage(from source: UIImagePickerControllerSourceType){
        let imagePickerController = UIImagePickerController()
        imagePickerController.delegate = self
        
        imagePickerController.sourceType = source
        imagePickerController.allowsEditing = false
        
        self.present(imagePickerController, animated: true, completion: nil)
    }
    
    
    func imagePickerController(_ picker: UIImagePickerController, didFinishPickingMediaWithInfo info: [String : Any]) {
        
        let chosenImage = info[UIImagePickerControllerOriginalImage] as! UIImage
        photo.contentMode = .scaleAspectFit
        photo.image = resizeImage(image: chosenImage)
        imageData = UIImageJPEGRepresentation(resizeImage(image: chosenImage), 1.0) as NSData?
        self.dismiss(animated: true, completion: nil)
        
    }
    
    func resizeImage(image: UIImage) -> UIImage {
        let size = image.size
        let limit:CGFloat = 150.0
        
        if (image.size.width > limit || image.size.height > limit) {
            let ratio = (image.size.width > image.size.height) ? limit / image.size.width : limit / image.size.height
           
            // Figure out what our orientation is, and use that to form the rectangle
            var newSize: CGSize
            
            newSize = CGSize(width:size.width * ratio,height:size.height * ratio)
            
            // This is the rect that we've calculated out and this is what is actually used below
            let rect = CGRect(origin: CGPoint(x:0, y:0), size: newSize)
            
            // Actually do the resizing to the rect using the ImageContext stuff
            UIGraphicsBeginImageContextWithOptions(newSize, false, 1.0)
            image.draw(in: rect)
            let newImage = UIGraphicsGetImageFromCurrentImageContext()
            UIGraphicsEndImageContext()
            
            return newImage!

        }
        else {
            return image
        }
        
    }
    
    func setplaceholder() {
        txtDescription.text = "Description"
        txtDescription.textColor = UIColor.lightGray
        txtRemark.text = "Remark"
        txtRemark.textColor = UIColor.lightGray
        
    }
    
    func textViewDidBeginEditing(_ textView: UITextView) {
        
        if textView.tag == 1 {
            if txtDescription.text == "Description" {
                txtDescription.text = ""
                txtDescription.textColor = UIColor.black
                txtDescription.becomeFirstResponder()
            }
            
        }
        else if textView.tag == 2 {
            if txtRemark.text == "Remark" {
                txtRemark.text = ""
                txtRemark.textColor = UIColor.black
                txtRemark.becomeFirstResponder()
            }
            
        }
        
        
    }
    
    func textViewDidChange(_ textView: UITextView) {
        if textView.tag == 1 {
            if txtDescription.text == "Description" {
                txtDescription.text = ""
                txtDescription.textColor = UIColor.black
                txtDescription.becomeFirstResponder()
            }
            else if txtDescription.text == "" {
                txtDescription.text = "Description"
                txtDescription.textColor = UIColor.lightGray
                txtDescription.resignFirstResponder()
            }
        }
        else if textView.tag == 2 {
            if txtRemark.text == "Remark" {
                txtRemark.text = ""
                txtRemark.textColor = UIColor.black
                txtRemark.becomeFirstResponder()
            }
            else if txtRemark.text == "" {
                txtRemark.text = "Remark"
                txtRemark.textColor = UIColor.lightGray
                txtRemark.resignFirstResponder()
            }
            
        }
    }
    
    func textViewDidEndEditing(_ textView: UITextView) {
        if textView.tag == 1 {
            if txtDescription.text == "" {
                txtDescription.text = "Description"
                txtDescription.textColor = UIColor.lightGray
                txtDescription.resignFirstResponder()
            }
           
        }
        else if textView.tag == 2 {
            if txtRemark.text == "" {
                txtRemark.text = "Remark"
                txtRemark.textColor = UIColor.lightGray
                txtRemark.resignFirstResponder()
            }
            
        }
    }
    
    func setBarcodeScanResult(which: String, result: String) {
        if which == "serialnumber" {
            serialNumber.text  = result
        }
        else if which == "partnumber" {
            partNumber.text = result
        }
    }
    
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        if pickerView.tag == 1 {
            return listdescriptiondata.count
        }
        else {
            return listlocationdata.count
        }
    }
    
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        if pickerView.tag == 1 {
            return listdescriptiondata[row]
        }
        else {
            return listlocationdata[row]
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        if pickerView.tag == 1 {
            txtDescription.text = listdescriptiondata[row]
            //pickerdescription.isHidden = true
            
            if txtDescription.text != "" {
                //txtDescription.text = ""
                txtDescription.textColor = UIColor.black
                //txtDescription.becomeFirstResponder()
            }
            else if txtDescription.text == "" {
                txtDescription.text = "Description"
                txtDescription.textColor = UIColor.lightGray
                //txtDescription.resignFirstResponder()
            }
        }
        else {
            txtLocation.text = listlocationdata[row]
            //pickerlocation.isHidden = true
        }
    }
    
  
    
    @IBAction func viewpickerdescription(_ sender: Any) {
        
        pickerpanel.isHidden = false
        pickerlocation.isHidden = true
        pickerdescription.isHidden = false
        pickerdescription.dataSource = self
        pickerdescription.delegate = self
        
    }
    

    @IBAction func addInventory(_ sender: Any) {
        
        partNumber.resignFirstResponder()
        serialNumber.resignFirstResponder()
        txtDescription.resignFirstResponder()
        txtRemark.resignFirstResponder()
        txtQuantity.resignFirstResponder()
        txtLocation.resignFirstResponder()
        
        partnumber = partNumber.text
        serialnumber = serialNumber.text
        strDescription = txtDescription.text
        strRemark = txtRemark.text
        if strRemark == "Remark" {
            strRemark = ""
        }
        strQuantity = txtQuantity.text
        strLoation = txtLocation.text
        
        if ((strDescription?.characters.count)! <= 0 || strDescription == "Description" || strDescription == "") {
            let alert = UIAlertController(title: "Warnning", message: "Invalid description", preferredStyle: UIAlertControllerStyle.alert)
            alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler:nil))
            self.present(alert, animated: true, completion: nil)
        }
        else if ((strQuantity?.characters.count)! <= 0 || strQuantity == "") {
            let alert = UIAlertController(title: "Warnning", message: "Invalid quantity", preferredStyle: UIAlertControllerStyle.alert)
            alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler:nil))
            self.present(alert, animated: true, completion: nil)
        }
        else if ((strLoation?.characters.count)! <= 0 || strLoation == "") {
            let alert = UIAlertController(title: "Warnning", message: "Invalid location", preferredStyle: UIAlertControllerStyle.alert)
            alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler:nil))
            self.present(alert, animated: true, completion: nil)
        }
        else {
            
            let session = SessionManager()
            let user_detail = session.getUserDetails()
            let user_id = user_detail[session.KEY_UserId]
            
            var encodedImage = ""
            if imageData != nil {
                
                encodedImage = imageData!.base64EncodedString(options: .lineLength64Characters)
            }
            
            let json = ["user_id":user_id, "photo":encodedImage, "part_number": partnumber, "serial_number":serialnumber, "location":strLoation, "quantity":strQuantity, "remark":strRemark, "description": strDescription]
            
            activityindicatorcontainer.isHidden = false
            
            
            do {
                let jsonData = try JSONSerialization.data(withJSONObject: json, options: .prettyPrinted)
                
                let url = StaticData.getlink() + "add_inventory.php"
                
                var request = URLRequest(url: URL(string: url)!)
                
                request.httpMethod = "POST"
                request.httpBody = jsonData
                //request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")
                
                
                let task = URLSession.shared.dataTask(with: request) { (data: Data?, response: URLResponse?, error: Error?) in
                    
                    if error != nil
                    {
                        print("error=\(error)")
                        return
                    }
                    
                    // You can print out response object
                    print("response = \(response)")
                    
                    //Let's convert response sent from a server side script to a NSDictionary object:
                    do {
                        
                        let json = try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as? NSDictionary
                        
                        if let parseJSON = json {
                            
                            
                            let error_message = parseJSON["error"] as! Bool
                            
                            DispatchQueue.main.async { [unowned self] in
                            
                                self.activityindicatorcontainer.isHidden = true
                                
                                if error_message {
                                    
                                    let alert = UIAlertController(title: "Warnning", message: "Failed registe new inventory", preferredStyle: UIAlertControllerStyle.alert)
                                    alert.addAction(UIAlertAction(title: "OK", style: UIAlertActionStyle.default, handler:nil))
                                    self.present(alert, animated: true, completion: nil)
                                    
                                }
                                else {
                                    
                                    
                                    
                                    self.navigationController?.popViewController(animated: true)
                                    
                                    
                                    
                                }

                            }
                            
                            
                        }
                        
                    } catch {
                        print("error")
                    }
                    
                    
                    
                }
                task.resume()
                
                
            } catch {
                print("error")
            }
            
            
            
            
            
        }
    }
    @IBAction func viewpickerlocation(_ sender: Any) {
        pickerpanel.isHidden = false
        pickerdescription.isHidden = true
        pickerlocation.isHidden = false
        pickerlocation.dataSource = self
        pickerlocation.delegate = self
        
    }
     @IBAction func takephoto(_ sender: Any) {
        selectImage(from: UIImagePickerControllerSourceType.camera)
        //selectImage(from: UIImagePickerControllerSourceType.photoLibrary)
    }
    
    @IBAction func pickerconfirm(_ sender: Any) {
        pickerpanel.isHidden = true
    }
    
    @IBAction func takePartNumber(_ sender: Any) {
    }
    @IBAction func takeSerialNumber(_ sender: Any) {
    }
}
